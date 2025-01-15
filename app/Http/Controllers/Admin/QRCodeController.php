<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreNetRequest;
use App\Http\Controllers\Controller;
use App\Models\ProductModel;

class QRCodeController extends Controller
{

    public function list(Request $request){
        $data['getRecord'] = ProductModel::get();
        return view('admin.qrcode.list', $data);
    }

    public function add_qrcode(Request $request){
        return view('admin.qrcode.add');
    }

    public function store_qrcode(Request $request){

        $number = mt_rand(11111111111,99999999999);

        $save = new ProductModel;
        $save->title            = trim($request->title);
        $save->price            = trim($request->price);
        $save->product_code     = $number;
        $save->description      = trim($request->description);
        $save->save();
          return redirect('admin/qrcode')->with('success', 'QRCode has been created successfully.');
    }

    public function qrcode_edit($id){
        $data['getRecord'] = ProductModel::find($id);
        return view('admin.qrcode.edit', $data);
    }

        public function qrcode_update($id, Request $request){

         $number = mt_rand(11111111111,99999999999);

        $save = ProductModel::find($id);
        $save->title            = trim($request->title);
        $save->price            = trim($request->price);
        $save->product_code     = $number;
        $save->description      = trim($request->description);
        $save->save();
          return redirect('admin.qrcode')->with('success', 'QRCode has been updated successfully.');
    }

    public function qrcode_delete($id){
       
            $deleteRecord = ProductModel::find($id);
            $deleteRecord->delete();
            return redirect('admin.qrcode')->with('success', 'QRCode has been deleted successfully.');
    }
}