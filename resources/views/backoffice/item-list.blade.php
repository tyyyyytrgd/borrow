@extends('layouts.backoffice-layout')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <div class="d-flex justify-content-between">
                            <div>รายการอุปกรณ์</div>
                            <div>
                                <a href="{{url('back-office/item/create')}}" class="btn btn-primary">เพิ่ม</a>
                            </div>
                        </div>
                    </h5>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>รูป</th>
                            <th>รหัสอุปกรณ์</th>
                            <th>ชื่ออุปกรณ์</th>
                            <th></th>
                        </tr>
                        </thead>
                        @if(!$items->isEmpty())
                        <tbody>
                           @foreach($items as $index=>$item)
                            <tr>
                                <td>{{$items->firstItem()+$index}}</td>
                                <td width="100">
                                    <img class="img-fluid"
                                         src="{{ url('/uploads/'.$item->image) }}">
                                </td>
                                <td>{{$item->id}}</td>
                                <td>{{$item->title}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{url(url('/back-office/item/'.$item->id))}}"
                                           class="btn btn-outline-primary">แก้ไข</a>
                                        <button class="btn btn-outline-danger" type="button"@click="submitDelete({{$item->id}})">ลบ</button>
                                    </div>
                                </td>
                            </tr>
                           @endforeach
                        </tbody>
                        @else
                            <tr>
                                <td colspan="5" class="text-center"> - ไม่พบข้อมูล - </td>
                            </tr>
                        @endif
                    </table>
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
            },
            methods:{
                submitDelete(id){
                    swal({
                        title: "ยืนยัน",
                        text: "คุณต้องการลบรายการนี้",
                        icon: "warning",
                        dangerMode: true,
                    })
                        .then(willDelete => {
                            if (willDelete) {
                                var formData = new FormData();
                                formData.append('_method', 'DELETE');
                                axios.post('/back-office/item'+'/'+id,
                                    formData,
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        }
                                    }
                                ).then(function(response){
                                    if (response.data.status==200) {
                                        swal({
                                            icon: "success",
                                            text: response.data.message,
                                            button:false,
                                        });
                                        setTimeout(function(){
                                            window.location.reload();
                                        },2000);
                                    }else{
                                        swal("ผิดพลาด",response.data.message, "error");
                                    }
                                })
                                    .catch(function(){
                                        console.log('error');
                                    });
                            }
                        });

                }
            }
        })
    </script>
@endpush
