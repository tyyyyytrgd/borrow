@extends('layouts.user-layout')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-end bd-highlight mb-3">
            <div class="p-2"><a href="/history">ประวัติ</a></div>
            <div class="p-2"><a href="/cart">ตระกร้า ( {{ $count_item_in_cart }} )</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>รูป</th>
                        <th>รหัสอุปกรณ์</th>
                        <th>รายละเอียด</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$carts->isEmpty())
                        @foreach($carts as $cart)
                            <tr>
                                <td width="150">
                                    <img class="img-fluid" src="{{ url('/uploads/'.$cart->item->image) }}">
                                </td>
                                <td class="align-middle">{{ $cart->item->id }}</td>
                                <td class="align-middle">{{ $cart->item->title }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-danger" @click="removeInCart({{$cart->item->id}})">ลบ</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-primary" @click="clearCart" >เคลียตระกร้า</button>
                    <button type="button" class="btn btn-success" @click="createOrder">ยืนยันรายการ</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {},
            methods: {
                removeInCart(id) {
                    axios.post('/cart/'+id+'/delete')
                        .then(function(response){
                            console.log(response);
                            if(response.data.status==200){
                                swal({
                                    icon:"success",
                                    text:response.data.message,
                                    button:false
                                });
                                setTimeout(function (){
                                    window.location.reload();
                                },2000);
                            }else{
                                swal("ผิดพลาด",response.data.message,"error");
                            }
                        })
                        .catch(function() {
                            console.log('errors');
                        });
                },
                clearCart() {
                    axios.post('/cart/delete')
                        .then(function(response){
                            console.log(response);
                            if(response.data.status==200){
                                swal({
                                    icon:"success",
                                    text:response.data.message,
                                    button:false
                                });
                                setTimeout(function (){
                                    window.location.reload();
                                },2000);
                            }else{
                                swal("ผิดพลาด",response.data.message,"error");
                            }
                        })
                        .catch(function() {
                            console.log('errors');
                        });
                },
                createOrder() {
                    axios.post('/cart')
                        .then(function(response){
                            console.log(response);
                            if(response.data.status==200){
                                swal({
                                    icon:"success",
                                    text:response.data.message,
                                    button:false
                                });
                                setTimeout(function (){
                                    window.location= '/history';
                                },2000);
                            }else{
                                swal("ผิดพลาด",response.data.message,"error");
                            }
                        })
                        .catch(function() {
                            console.log('errors');
                        });
                }
            }
        })
    </script>
@endpush
