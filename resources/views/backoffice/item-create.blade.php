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
                                    <div>Create</div>
                                </div>
                            </h5>
                            <form>
                                <div class="form-group">
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
                                <button type="button" class="btn btn-primary"@click="submit">Submit</button>
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
            data: {
                title: '',
                detail:'',
                image:''
            },
            methods: {
                handleFileUpload(){
                    this.image = this.$refs.image.files[0];
                    console.log(this.image);
                },
                submit(){
                    var formData = new FormData();
                    formData.append('title',this.title);
                    formData.append('detail',this.detail);
                    formData.append('image',this.image);
                    // console.log(formData);
                    axios.post('/back-office/item',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(response){
                        console.log(response);
                        if (response.data.status==200){
                            window.location = '/back-office/item';
                        }else{
                            swal("ผิดพลาด",response.data.message,"error");
                        }

                    })
                        .catch(function(){
                            console.log('error');
                        });
                }
            }
        })
    </script>
@endpush
