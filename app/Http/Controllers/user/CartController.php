<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopItem;
use App\Models\PointShopTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function cleanCartSession($userId)
    {
        $cart = session()->get("cart.$userId", []);
        $cleanedCart = array_filter($cart, function ($item) {
            return is_array($item) && isset($item['item_id']) && !empty($item);
        });
        session()->put("cart.$userId", $cleanedCart);
    }

    public function index()
    {
        $user = Auth::user();
        $userId = auth()->id();
        $totalPoints = $user->userPoints()->sum('points');

        $cart = session("cart.$userId", []);
        return view('user.pointCart', compact('cart', 'totalPoints'));
    }
    public function add(Request $request)
    {
        $userId = auth()->id();
        $itemId = $request->input('item_id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get("cart.$userId", []);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['qty'] += $quantity;
        } else {
            // 🔥 ganti model dari PointShopTransaction ke ShopItem
            $item = ShopItem::findOrFail($itemId);

            $cart[$itemId] = [
                'item_id' => $item->id,
                'name' => $item->name,
                'point_cost' => $item->point_cost,
                'qty' => $quantity,
                'image' => $item->image,
            ];
        }

        session()->put("cart.$userId", $cart);

        return response()->json(['message' => 'Item berhasil ditambahkan ke keranjang']);
    }

    public function count()
    {
        $userId = auth()->id();
        $cart = session()->get("cart.$userId", []);
        $totalItems = array_sum(array_column($cart, 'qty'));

        return response()->json(['count' => $totalItems]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();
        $cart = session()->get("cart.$userId", []);

        if (!isset($cart[$request->item_id])) {
            return redirect()->route('user.cart')->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $oldQty = $cart[$request->item_id]['qty'];
        $cart[$request->item_id]['qty'] = $request->quantity;

        session()->put("cart.$userId", $cart);

        LogHelper::record(
            'Memperbarui jumlah item di keranjang',
            "User ID: {$userId}, Item ID: {$request->item_id}, Sebelumnya: {$oldQty}, Sekarang: {$request->quantity}"
        );

        return redirect()->route('user.cart')->with('success', 'Jumlah item berhasil diperbarui.');
    }


    public function delete(Request $request)
    {
        $userId = auth()->id();
        $itemId = $request->input('item_id');

        $cart = session()->get("cart.$userId", []);
        unset($cart[$itemId]);

        session()->put("cart.$userId", $cart);

        return response()->json(['message' => 'Item dihapus']);
    }


    public function checkout(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $cart = session()->get("cart.$userId", []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return back()->with('error', 'Pilih setidaknya satu item untuk checkout.');
        }

        $totalPointsNeeded = 0;
        $checkedOutItems = [];

        foreach ($cart as $item) {
            if (in_array($item['item_id'], $selectedItems)) {
                $totalPointsNeeded += $item['qty'] * $item['point_cost'];
                $checkedOutItems[] = $item;
            }
        }

        if ($user->userPoints()->sum('points') < $totalPointsNeeded) {
            return back()->with('error', 'Poin Anda tidak mencukupi.');
        }

        foreach ($checkedOutItems as $item) {
            $shopItem = ShopItem::find($item['item_id']);
            if (!$shopItem || $shopItem->stock < $item['qty']) {
                return back()->with('error', "Stok tidak cukup untuk item {$item['name']}.");
            }

            $shopItem->decrement('stock', $item['qty']);
            PointShopTransaction::create([
                'user_id' => $user->id,
                'shop_item_id' => $shopItem->id,
                'quantity' => $item['qty'],
                'point_used' => $shopItem->point_cost * $item['qty'],
            ]);
        }

        $user->userPoints()->create([
            'points' => -$totalPointsNeeded,
            'pickup_id' => null,
            'description' => 'Penukaran sebagian item dari toko poin',
        ]);

        // Simpan ulang sisa cart
        $remainingCart = array_filter($cart, fn($c) => !in_array($c['item_id'], $selectedItems));
        session()->put("cart.$userId", $remainingCart);

        LogHelper::record(
            'Checkout toko poin',
            "Total poin: {$totalPointsNeeded}, Jumlah item: " . count($checkedOutItems)
        );

        return back()->with('success', 'Checkout berhasil untuk item terpilih.');
    }

}
