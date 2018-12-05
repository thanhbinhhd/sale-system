@extends('user.layout.master')
@section('customCss')
    <style>
        .pass_show {
            position: relative
        }

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

        .margin-top-15 {
            margin-top: 15px;
        }

        .pass_show .ptxt:hover {
            color: #333333;
        }

        @media (min-width: 576px){
            #updateProfile .modal-dialog {
                max-width: 75%;
            }
        }

    </style>

@endsection
@section('content')
    <div class="container panel panel-info pb-3">
        <div class="panel-heading">
            <h3 class="panel-title" id="name">{{$user->name}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 col-6 m-auto" align="center">
                    @if($user->avatar)
                    <img alt="User Pic" src="{{\Illuminate\Support\Facades\Storage::url($user->avatar)}}" class="rounded-circle img-fluid" id="avatar-user">
                        @else
                        <img src="/admin/images/avatar.jpg" class="rounded-circle img-fluid" alt="ICON">
                    @endif
                    <div>
                        <input hidden type="file" id="input-upload-avatar" accept="image/png, image/jpeg, image/jpg"/>
                        <button class="btn btn-primary margin-top-15" id="upload-avatar">Upload Avatar</button>
                    </div>
                </div>

                <div class="col-md-9 mt-5">
                    <table class="table table-user-information">
                        <tbody>
                        <tr>
                            <td>Email:</td>
                            <td id="email">{{$user->email}}</td>
                        </tr>


                        <tr>
                        <tr>
                            <td>Phone number</td>
                            <td id="phone">{{$user->phone_number}}</td>
                        </tr>
                        <tr>
                            <td>Home Address</td>
                            <td id="address">{{$user->address}}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td id="description">{{$user->description}}</td>
                        </tr>

                        </tr>

                        </tbody>
                    </table>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changepass">
                        Change password
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#updateProfile">
                        Update Profile
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
                    <h5 class="modal-title" id="changepassLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Current Password</label>
                    <div class="form-group pass_show">
                        <input type="password" class="form-control border" id="currentpass"
                               placeholder="Current Password">
                    </div>
                    <label>New Password</label>
                    <div class="form-group pass_show">
                        <input type="password" class="form-control border" id="newpass" placeholder="New Password">
                    </div>
                    <label>Confirm Password</label>
                    <div class="form-group pass_show">
                        <input type="password" class="form-control border" id="confirmpass"
                               placeholder="Confirm Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="changepassBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="updateProfile"
         aria-hidden="true">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileLabel">Change Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Name</label>
                        <input type="text" class="form-control border" id="eName" aria-describedby="emailHelp" value="{{$user->name}}" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="text" class="form-control border" id="eEmail" placeholder="Email" value="{{$user->email}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Phone number</label>
                        <input type="text" class="form-control border" id="ePhone" value="{{$user->phone_number}}" placeholder="Phone number">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Address</label>
                        <input type="text" class="form-control border" id="eAddress" value="{{$user->address}}" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Description</label>
                        <textarea class="form-control" id="eDescription" cols="30" rows="10" maxlength="255" value="{{$user->description}}" placeholder="Description..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateProfileBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('customJs')
    <script>
        $(document).ready(function () {
            $('.pass_show').append('<span class="ptxt">Show</span>');
            $('#upload-avatar').on('click', function() {
              $('#input-upload-avatar').click();
            })
            $('#input-upload-avatar').on('change', function($event) {
              let fileUpload = $event.target.files[0];
              let uploadFile = (fileUpload) => {
                console.log('file: ', fileUpload)

                let formData = new FormData();
                formData.append('avatar', fileUpload);
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  }
                });
                formData.append("upload_file", true);
                $.ajax({
                  type: 'POST',
                  url: '/upload-avatar',
                  async: true,
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function (response) {
                    if (!response.error) {
                      toastr.success('Avatar Upload Successfully!');
                      $('#avatar-user').attr("src", response.image_address);
                    }
                    else {
                      toastr.warning('Something error when uploading!');
                    }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    toastr.error(xhr.responseJSON.message);
                  }
                });
              }
              uploadFile(fileUpload)

            })
        });

        $(document).on('click', '.pass_show .ptxt', function () {

          $(this).text($(this).text() == "Show" ? "Hide" : "Show");

          $(this).prev().attr('type', function (index, attr) {
            return attr == 'password' ? 'text' : 'password';
          });



        });


        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#changepassBtn").on("click", function () {
                var currentpass = $("#currentpass").val();
                var newpass = $("#newpass").val();
                var confirmpass = $("#confirmpass").val();
                if (!(currentpass && newpass && confirmpass)) {
                    toastr.warning('Please enter the full fields!');
                }
                else if (newpass !== confirmpass) {
                    toastr.warning('New password and confirm password must be the same!');
                }
                else {
                    $.ajax({
                        type: 'PUT',
                        url: '/change-pass',
                        data: {
                          old_password: currentpass,
                          new_password: newpass,
                          new_password_confirmation: confirmpass
                        },
                        success: function (response) {
                            if (!response.error) {
                                if (response.data === "success") {
                                    toastr.success('Changpass is successfully!');
                                    $("#changepass").modal('hide');
                                }
                                else {
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
            
            $("#updateProfileBtn").on("click",function () {
                var name = $("#eName").val();
                var phone = $("#ePhone").val();
                // var avatar = $("#eAvatar");
                var address = $("#eAddress").val();
                var description = $("#eDescription").val();
                if(!name){
                    toastr.warning('Please enter the name!');
                }
                else{
                    $.ajax({
                        type: 'PUT',
                        url: '/change-profile',
                        data: {
                            name: name,
                            phone: phone,
                            address: address,
                            description: description,
                        },
                        success: function (response) {
                            if (!response.error) {
                                toastr.success('update is successfully!');
                                $("#updateProfile").modal('hide');
                                updateScreen(response.data);
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }

            })

            function updateScreen(data) {
                $("#name").html(data.name);
                $("#phone").html(data.phone_number);
                $("#address").html(data.address);
                $("#description").html(data.description);
            }
        });
    </script>
@endsection
