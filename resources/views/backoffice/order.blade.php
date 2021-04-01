@extends('layouts.backoffice-layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" class="form-control" v-model="order_id">
                    <div class="input-group-append">
                        <button class="btn btn-secondary"
                                @click="searchOrder">ค้นหา</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4" v-if="Object.keys(order).length > 0">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>รูป</th>
                        <th>รหัสอุปกรณ์</th>
                        <th>รายละเอียด</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="detail in order.details">
                        <td width="100">
                            <img class="img-fluid" :src="'/uploads/'+detail.item.image">
                        </td>
                        <td class="align-middle">@{{ detail.item.id }}</td>
                        <td class="align-middle">@{{ detail.item.detail }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <select class="form-control" v-model="order.status">
                    <option value="0">รอดำเนินการ</option>
                    <option value="1">อนุมัติรายการ</option>
                    <option value="2">รับอุปกรณ์</option>
                    <option value="3">คืนอุปกรณ์</option>
                    <option value="4">ไม่ได้รับการอนุมัติ</option>
                </select>
            </div>
            <div class="col-md-12 mt-3">
                <div style="..." v-if="!order.image_sign">
                    <div id="signature"></div>
                </div>
                <div style="border: 1px dotted" v-else>
                    <img :src="'/uploads/signature/'+order.image_sign" class="img-fluid">
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <button class="btn btn-outline-info"
                            @click="clearSign">ล้างลายเซ็น</button>
                    <button class="btn btn-success"
                            @click="submit">บันทึกข้อมูล</button>
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
                order_id:'',
                order:{},
            },
            methods: {
                searchOrder() {
                    var _this = this;
                    axios.get('/back-office/order/'+this.order_id)
                        .then(function(response){
                            if(response.data.status==200){
                                _this.order = response.data.order;
                            }else{
                                swal("ผิดพลาด",response.data.message,"error");
                            }
                        })
                        .catch(function() {
                            console.log('errors');
                        });
                },
                bindSignPad() {
                    $('#signature').jSignature();
                },
                clearSign(){
                    $('#signature').jSignature('reset');
                },
                submit(){
                    var sign_length = 0;
                    var sign_img = '';
                    if (this.order.status==1) {
                        sign_length = $('#signature').jSignature('getData','native').length;
                        sign_img = $('#signature').jSignature('getData','image');
                    }
                    axios.post('/back-office/order/'+this.order_id,{
                        status:this.order.status,
                        sign_img:sign_img,
                        sign_length:sign_length,
                        _method:'PUT'
                    })
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
            },
            updated(){
                this.bindSignPad();
            }
        })
    </script>
@endpush
