<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
class FlashSaleController extends Controller
{

    public function index(FlashSaleItemDataTable $dataTable)
    {
        $flashSaleDate = FlashSale::first();
        $products      = Product::where('is_approved', 1)->where('status', 1)->orderBy('id', 'DESC')->get();
        return $dataTable->render('admin.flash_sale.index', compact('flashSaleDate', 'products'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'end_date' => 'required|date',
        ]);


        FlashSale::updateOrCreate(
            [ 'id' => 1 ], // Assuming you want to update the flash sale with ID 1
            [ 'end_date' => $request->end_date ]
        );

        toastr()->success('Flash Sale end date updated successfully!');
        return redirect()->back();


    }

    public function addProduct(Request $request)
    {
        // Validate the request
        $request->validate([
            'product'      => 'required',
            'show_at_home' => 'required',
            'status'       => 'required'
        ]);

        $flashSale                = new FlashSaleItem();
        $flashSale->flash_sale_id = 1; // Assuming you want to associate it with flash sale ID 1
        $flashSale->product_id    = $request->product;
        $flashSale->show_at_home  = $request->show_at_home;
        $flashSale->status        = $request->status;
        $flashSale->save();

        toastr()->success('Product added to flash sale successfully!');
        return redirect()->back();
    }

    public function chageShowAtHomeStatus(Request $request)
    {
        $flashSaleItem               = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->show_at_home = $request->show_at_home == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response()->json([ 'success' => true, 'message' => 'Show at home status updated successfully.' ]);
    }

    public function changeStatus(Request $request)
    {
        $flashSaleItem         = FlashSaleItem::findOrFail($request->id);
        $flashSaleItem->status = $request->status == 'true' ? 1 : 0;
        $flashSaleItem->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Flash Sale Item status changed successfully.',
        ]);
    }


    public function destroy($id)
    {
        $flashSaleItem = FlashSaleItem::findOrFail($id);
        $flashSaleItem->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Flash Sale Item deleted successfully.',
        ]);
    }
}
