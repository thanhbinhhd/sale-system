$(document).ready(function () {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $("#subscribe-btn").on("click",function () {               
    
    var email =  $("#subscribe-email").val();
    if(IsEmail(email)==false){
      toastr.error("Email invalid");
      return false;
    }else {
      $.ajax({
        type:'POST',
        url: 'create-subscribe',
        data:{
            email:email,
        },
        success: function (response) {
            if(!response.error){
                toastr.success(email +' - Subscribe Successfully!');
                $("#subscribe-email").val("");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(xhr.responseJSON.message);
        }
      });
    }
  });

  
});

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}