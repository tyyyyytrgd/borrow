@extends('layouts.user-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10">
                <form action="/" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search"
                               value="{{Request::get('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary">ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <div class="d-flex justify-content-end bd-highlight mb-3">
                    <div class="p-2"><a href="/history">ประวัติ</a></div>
                    <div class="p-2"><a href="/cart">ตระกร้า ( {{ $count_item_in_cart }} )</a></div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(!$items->isEmpty())
                @foreach($items as $item)
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top img-fluid"
                                 src="{{ url('/uploads/'.$item->image) }}" height="100" style="height: 200px;object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{$item->title}}</h5>
                                <p class="card-text">{{$item->detail}}</p>
                                <button type="button" class="btn btn-primary"
                                        @click="addToCart({{$item->id}})">เพิ่มลงตระกร้า</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {},
            methods: {
                addToCart(id) {
                    axios.post('/cart/'+id+'/add')
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
                }
            }
        })
    </script>
@endpush
