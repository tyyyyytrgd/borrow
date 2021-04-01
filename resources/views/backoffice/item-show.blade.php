@extends('layouts.backoffice-layout')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <h5 class="card-title">
                                <div class="d-flex justify-content-between">
                                    <div>Show</div>
                                </div>
                            </h5>
                            <form>
                                <div class="form-group">
                                    <div :style="{
                                        backgroundImage: 'url(/uploads/'+old_image+')',
                                        backgroundSize: 'cover',
                                        backgroundColor: 'red',
                                        width: '100px',
                                        height: '100px',
                                        borderRadius: '50px',
                                        backgroundPosition:'center',
                                        color:'white',
                                        textAlign:'center'
                                    }" >@{{title}}</div>
                                    <label for="title">ชื่ออุปกรณ์</label>
                                    <input type="text" class="form-control" id="title" v-model="title">
                                </div>
                                <div class="form-group">
                                    <label for="detail">รายละเอียด</label>
                                    <input type="text" class="form-control" id="detail" v-model="detail">

                                </div>
                                <div class="form-group">
                                    <label for="image">รูป</label>
                                    <input type="file" class="form-control-file"
                                           ref="image" @change="handleFileUpload()">

                                </div>
                                <button type="button" class="btn btn-primary"
                                        @click="submit">Submit</button>
                            </form>
                        </div>
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
            data:{!! $result !!},
            methods: {
                handleFileUpload(){
                    this.image = this.$refs.image.files[0];
                    console.log(this.image);
                },
                submit() {
                    var formData = new FormData();
                    formData.append('title',this.title);
                    formData.append('detail',this.detail);
                    formData.append('image',this.image);
                    formData.append('old_image',this.old_image);
                    formData.append('_method','PUT');
                    //console.log(formData);
                    axios.post('/back-office/item/'+this.id,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(response){
                        console.log(response);
                        if(response.data.status==200){
                            swal({
                                icon:"success",
                                text:response.data.message,
                                button:false
                            });
                            setTimeout(function (){
                                window.location.reload();
                            },200);
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
