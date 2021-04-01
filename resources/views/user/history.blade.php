@extends('layouts.user-layout')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-end bd-highlight mb-3">
            <div class="p-2"><a href="/history">ประวัติ</a></div>
            <div class="p-2"><a href="/cart">ตระกร้า ({{ $count_item_in_cart }})</a></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>เลขที่รายการ</th>
                        <th>สถานะ</th>
                        <th>วันที่สิ้นสุดการยืม</th>
                        <th>รายละเอียด</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$orders->isEmpty())
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    @if($order->status == 0)
                                        รอดำเนินการ
                                    @elseif($order->status == 1)
                                        อนุมัติแล้ว
                                    @elseif($order->status == 2)
                                        รับอุปกรณ์แล้ว
                                    @elseif($order->status == 3)
                                        คืนอุปกรณ์แล้ว
                                    @else
                                        ไม่ได้รับการอนุมัติ
                                    @endif
                                </td>
                                <td>
                                    {{ \App\Utils\Helper::dateToThai($order->end_date) }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" @click="showDetail({{$order->id}})">รายละเอียด</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--    <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">--}}
    {{--        <div id="modal_content" class="modal-dialog modal-lg" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    ...--}}
    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div id="modal_content" class="modal-dialog modal-lg" role="document">

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {},
            methods: {
                showDetail(id) {
                    axios.get('/history/'+id)
                        .then(function(response){

                            if(response.data.status==200){
                                $('#modal_content').html(response.data.html);
                                $('#modal_detail').modal('show');
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
