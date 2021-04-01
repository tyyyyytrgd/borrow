<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Traits\Date;
use http\Env\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index() {
        return view('backoffice.order');
    }

    public function show($id){
        $order = Order::with(['details.item'])->Where('id',$id)->first();
        if (!$order){
            return response()->json(['order'=>[],'status'=>200]);
        }
        $order = $order->toArray();

        return response()->json(['order'=>$order,'status'=>200]);
    }
    public function update(Request $request,$id){
        $status = $request->get('status');
        $sign_img = $request->get('sign_img');
        $sign_length = $request->get('sign_length');

        $order = Order::find($id);
        if($status < $order->status){
            return response()->json(['message'=>'อย่ามั่วอนุมัติน้อนหลัง','status'=>422]);
        }

        if($status == 1){
            if(empty($sign_length)) {
                return response()->json(['message'=>'กรุณาระบุลายเซ็น','status'=>422]);
            }
            $image_name = $id.'_sign.png';
            $path = public_path('/uploads/signature'.$image_name);
            file_put_contents($path,base64_decode($sign_img[1]));
            $order->image_sign = $image_name;
        }

        if($status == 2) {
            $order->start_date = Date('Y-m-d');
            $order->end_date = Date('Y-m-d',strtotime(Date('Y-m-d')." +7 day"));
        }

        $order->status = $status;
        $order->save();

        return response()->json(['message'=>'บันทึกข้อมูลเรียบร้อยแล้ว','status'=>200]);
    }
}
