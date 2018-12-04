@extends('user.layout.master')
@section('customCss')
    <style>
        .pass_show{position: relative}

        .pass_show .ptxt {

            position: absolute;

            top: 50%;

            right: 10px;

            z-index: 1;

            color: #f36c01;

            margin-top: -10px;

            cursor: pointer;

            transition: .3s ease all;

        }

        .pass_show .ptxt:hover{color: #333333;}
    </style>

@endsection
@section('content')
    <div class="container panel panel-info pb-3">
        <div class="panel-heading">
            <h3 class="panel-title">{{$user->name}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 col-6 m-auto" align="center">
                    <img alt="User Pic" src="{{$user->avatar}}" class="rounded-circle img-fluid">
                </div>

                <div class="col-md-9 mt-5">
                    <table class="table table-user-information">
                        <tbody>
                        <tr>
                            <td>Email:</td>
                            <td>{{$user->email}}</td>
                        </tr>


                        <tr>
                        <tr>
                            <td>Phone number</td>
                            <td>{{$user->phone_number}}</td>
                        </tr>
                        <tr>
                            <td>Home Address</td>
                            <td>{{$user->address}}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{$user->description}}</td>
                        </tr>

                        </tr>

                        </tbody>
                    </table>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changepass">
                        Change password
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="changepass" tabindex="-1" role="dialog" aria-labelledby="changepass" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chaneg Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Current Password</label>
                    <div class="form-group pass_show">
                        <input type="password" class="form-control border" id="currentpass" placeholder="Current Password">
                    </div>
                    <label>New Password</label>
                    <div class="form-group pass_show">
                        <input type="password" class="form-control border" id="newpass" placeholder="New Password">
                    </div>
                    <label>Confirm Password</label>
                    <div class="form-group pass_show">
                        <input type="password" class="form-control border" id="confirmpass" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="changepassBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        $(document).ready(function(){
            $('.pass_show').append('<span class="ptxt">Show</span>');
        });


        $(document).on('click','.pass_show .ptxt', function(){

            $(this).text($(this).text() == "Show" ? "Hide" : "Show");

            $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });

        });



        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#changepassBtn").on("click",function () {
                var currentpass = $("#currentpass").val();
                var newpass = $("#newpass").val();
                var confirmpass = $("#confirmpass").val();
                if(!(currentpass && newpass && confirmpass)){
                    toastr.warning('Please enter the full fields!');
                }
                else if(newpass != confirmpass){
                    toastr.warning('New password and confirm password must be the same!');
                }
                else{
                    $.ajax({
                        type:'PUT',
                        url: '/changepass',
                        data:{
                            currentpass:currentpass,
                            newpass:newpass,
                        },
                        success: function (response) {
                            if(!response.error)
                            {
                                console.log(response.data);
                                console.log(response.data==="success");
                                if(response.data==="success"){
                                    toastr.success('Changpass is successfully!');
                                    $("#changepass").modal('hide');
                                }
                                else{
                                    toastr.warning('Password is invalid!');
                                }
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
