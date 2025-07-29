<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopItem;
use App\Models\ShopItemImage;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;

class ShopItemController extends Controller
{
    public function index()
    {
        $items = ShopItem::with('images')->paginate(8);
        return view('admin.pointShopManagement', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'point_cost' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:2048',
            'id' => 'nullable|exists:shop_items,id', // untuk update
        ]);

        if ($request->filled('id')) {
            $item = ShopItem::findOrFail($request->id);
            $item->update([
                'name' => $validated['name'],
                'point_cost' => $validated['point_cost'],
                'stock' => $validated['stock'],
            ]);

            LogHelper::record(
                'Memperbarui item shop',
                'ID: '.$item->id.', Nama: '.$item->name
            );
        } else {
            $item = ShopItem::create([
                'name' => $validated['name'],
                'point_cost' => $validated['point_cost'],
                'stock' => $validated['stock'],
            ]);

            LogHelper::record(
                'Menambahkan item shop',
                'ID: '.$item->id.', Nama: '.$item->name
            );
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('shop_items', 'public');
                $item->images()->create(['image_path' => $path]);
            }

            LogHelper::record(
                'Menambahkan gambar untuk item shop',
                'ID: '.$item->id.', Jumlah gambar: '.count($request->file('images'))
            );
        }

        return redirect()->back()->with('success', 'Item berhasil disimpan');
    }

    public function destroy($id)
    {
        $item = ShopItem::findOrFail($id);

        foreach ($item->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        LogHelper::record(
            'Menghapus item shop',
            'ID: '.$item->id.', Nama: '.$item->name
        );

        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus');
    }
}
