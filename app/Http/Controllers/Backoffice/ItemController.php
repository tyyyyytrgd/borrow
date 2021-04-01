<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items = Item::orderBy('id','desc')->paginate(1);
        return  view('backoffice.item-list',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return  view('backoffice.item-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->all());
        if (empty($request->get('title'))) {
           return response()->json(['message'=>'ระบุชื่ออุปกรณ์','status'=>422]);
       }
        if (empty($request->get('detail'))) {
            return response()->json(['message'=>'ระบุรายละเอียด','status'=>422]);
        }
        if (empty($request->hasFile('image'))) {
            return response()->json(['message'=>'ระบุรูปภาพ','status'=>422]);
        }
        $data = [];
        $file = $request->file('image');
        $path = public_path('/uploads/');
        $image = date('YmdHis').".".$file->getClientOriginalExtension();
        $file->move($path,$image);

        $data['image'] = $image;
        $data['title'] = $request->get('title');
        $data['detail'] = $request->get('detail');
        $data['status'] = 0;

        Item::create($data);
        return response()->json(['message'=>'บันทึกเรียบร้อยแล้ว','status'=>200]);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $item = Item::find($id);

        $result = json_encode([
            'id' => $item->id,
            'title' => $item->title,
            'detail' => $item->detail,
            'image' => '',
            'old_image' => $item->image
        ]);
        return view('backoffice.item-show', compact('result'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (empty($request->get('title'))) {
            return response()->json(['message'=>'ระบุชื่ออุปกรณ์','status'=>422]);
        }
        if (empty($request->get('detail'))) {
            return response()->json(['message'=>'ระบุรายละเอียด','status'=>422]);
        }
        if ($request->hasFile('image') && empty($request->get('old_image'))) {
            return response()->json(['message'=>'ระบุรูปภาพ','status'=>422]);
        }
//        $data = [];
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $path = public_path('/uploads/');
            $image = date('YmdHis').".".$file->getClientOriginalExtension();
            $file->move($path,$image);

        }else{
            $image = $request->get('old_image');
        }

        $item = Item::find($id);
        $item->image = $image;
        $item->title = $request->get('title');
        $item->detail = $request->get('detail');
        $item->save();

//        Item::create($data);
        return response()->json(['message'=>'บันทึกเรียบร้อยแล้ว','status'=>200]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $item = Item::find($id);
        $item->deleted_at = date('Y-m-d H:i:s');
        $item->save();

        return response()->json(['message'=>'ลบข้อมูลเรียบร้อยแล้ว','status'=>200]);

    }
}
