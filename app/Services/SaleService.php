<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleService
{
    /**
     * Process a sale transaction.
     *
     * @throws Exception If stock is insufficient or a DB error occurs.
     */
    public function processSale(array $data, ?int $cashierId): Sale
    {
        return DB::transaction(function () use ($data, $cashierId) {
            $totalAmount = 0;
            $saleItemsData = [];

            // 1. Verify stock and calculate totals
            foreach ($data['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw new Exception("Insufficient stock for product: {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $saleItemsData[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock_quantity', $item['quantity']);
                $product->increment('sold_quantity', $item['quantity']);
            }

            $discountPercent = isset($data['discount_percent']) ? max(0, min(100, $data['discount_percent'])) : 0;
            $discountAmount = round($totalAmount * ($discountPercent / 100), 2);
            $netAmount = round($totalAmount - $discountAmount, 2);

            $sale = Sale::create([
                'user_id' => $cashierId,
                'customer_id' => $data['customer_id'] ?? null,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'net_amount' => $netAmount,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'status' => 'completed',
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
            ]);

            $sale->items()->createMany($saleItemsData);

            if (! empty($sale->customer_id)) {
                Customer::find($sale->customer_id)?->increment('loyalty_points', floor($netAmount / 10));
            }

            return $sale;
        });
    }
}