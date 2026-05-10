<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Services\SaleService;
use Exception;
use Illuminate\Http\RedirectResponse;

class SaleController extends Controller
{
    protected SaleService $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = Sale::with(['customer', 'cashier'])->orderByDesc('created_at')->paginate(20);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'reorder_threshold')
            ->orderBy('stock_quantity')
            ->get();

        return view('sales.create', compact('products', 'lowStockProducts'));
    }

    public function store(StoreSaleRequest $request): RedirectResponse
    {
        try {
            $sale = $this->saleService->processSale(
                $request->validated(),
                auth()->id()
            );

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Sale processed successfully.');

        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['items.product', 'customer', 'cashier']);

        return view('sales.show', compact('sale'));
    }
}
