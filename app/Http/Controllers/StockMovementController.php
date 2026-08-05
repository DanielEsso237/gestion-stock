<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockEntryRequest;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreStockExitRequest;

class StockMovementController extends Controller
{
    public function storeIn(StoreStockEntryRequest $request, Product $product): RedirectResponse
    {
        DB::transaction(function () use ($request, $product) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => 'in',
                'quantity' => $request->validated('quantity'),
                'reason' => $request->validated('reason'),
            ]);

            $product->increment('quantity', $request->validated('quantity'));
        });

        return redirect()->route('products.index')->with('status', 'stock-in-recorded');
    }

        
    public function storeOut(StoreStockExitRequest $request, Product $product): RedirectResponse
    {
        DB::transaction(function () use ($request, $product) {
            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => $request->user()->id,
                'type' => 'out',
                'quantity' => $request->validated('quantity'),
                'reason' => $request->validated('reason'),
            ]);
            $product->decrement('quantity', $request->validated('quantity'));
        });

        return redirect()->route('products.index')->with('status', 'stock-out-recorded');
    }
}