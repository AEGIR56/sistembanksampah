<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ShopItem;
use App\Models\PointShopTransaction;
use App\Helpers\LogHelper;

class PointExchangeController extends Controller
{
    /**
     * Tampilkan halaman toko user dan daftar item.
     */
    public function index()
    {
        $items = ShopItem::with('images')->get();
        $user = Auth::user();
        $totalPoints = $user->userPoints()->sum('points');

        return view('user.pointexchange', compact('items', 'user', 'totalPoints'));
    }

    /**
     * Proses penukaran item oleh user.
     */
    public function exchange(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:shop_items,id',
        ]);

        $user = Auth::user();
        $item = ShopItem::findOrFail($request->item_id);
        $userPoints = $user->userPoints()->sum('points');

        if ($item->stock < 1) {
            return redirect()->back()->with('error', 'Stok item tidak tersedia.');
        }

        if ($userPoints < $item->point_cost) {
            return redirect()->back()->with('error', 'Poin Anda tidak cukup.');
        }

        // Kurangi stok item
        $item->decrement('stock');

        // Catat transaksi penukaran poin
        PointShopTransaction::create([
            'user_id' => $user->id,
            'shop_item_id' => $item->id,
            'points_spent' => $item->point_cost,
        ]);

        // Catat ke log
        LogHelper::record(
            'User menukar poin dengan item',
            "Item: {$item->name}, Poin digunakan: {$item->point_cost}, Sisa stok: {$item->stock}"
        );

        return redirect()->back()->with('success', 'Item berhasil ditukar.');
    }
}
