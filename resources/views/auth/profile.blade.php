@include('../header')

<style>
    .verified{
        color: green;
    }
    
    .update
    {
        cursor: pointer;
        background-color: green;
        border-style: none;
        border-radius: 15px;
        padding: 12px 6px;
        width: 100%;
        color: #fff;
        font-size: 15px;
        font-weight: bold;
        margin-top: 32px;
    }
    .result{
    color: green;
    text-align: center;
    position: absolute;
    justify-content: center;
    align-items: center;
    transform: translateX(-1%);
    padding: 5px;
    left: 45%;
    }
  
    input
    {
        border-style: none;
        border-radius: 15px;
        padding: 12px 2px;
        background: gray;
        margin: 2px;
        text-align: center;
        width: 100%;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }

    form
    {
        background: gainsboro;
        width: 500px;
        height: 400px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 12px;
        transform: translateY(30%);   
        margin: 0 auto;    
        border-radius: 20px;         
    }

    .email_verify
    {
        text-align: center;
    }
    .verify_email{
            cursor: pointer;
            background-color: rgb(213, 45, 20);
            border-style: none;
            border-radius: 25px;
            padding: 5px 1px;
            width: 110px;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
          }
</style>


<form action="" id="profile_form">
@csrf


<div class="email_verify">
    <h1>Hello, <span class="name"></span></h1>
    <p><b>Email:- <span class="email"></span> &nbsp; <span class="verify"></span> </b></p>
</div>
<input type="text" hidden name="id" id="user_id">
<input type="text" placeholder="Enter Name" name="name" id="name">
<br>
<span class="error name_err" style="color: red;"></span>
<br>

<input type="text" placeholder="Enter Email" name="email" id="email">
<br>
<span class="error email_err" style="color: red;"></span>
<br>&nbsp;

<button class="update">Update Profile</button>

</form>
<div class="result"></div>


<script>
    $(document).ready(function(){
        $.ajax({
            url: "http://127.0.0.1:8000/api/profile",
            type: "GET",
            headers: {'Authorization': localStorage.getItem('access_token')},
            success: function(data){
                if(data.status == 'true'){
                    $(".name").text(data.data.name);
                    $(".email").text(data.data.email);
                    $("#user_id").val(data.data.id);
                    $("#name").val(data.data.name);
                    $("#email").val(data.data.email);

                    if(data.data.is_verified == 0){
                        $(".verify").html("<button class='verify_email' data-id='"+data.data.email+"'>Verify</button>");
                    }else{
                        $(".verify").addClass("verified").text("Verified");
                    }
                }else{
                    alert(data.message);
                }
            }
        });

        //profile update

        $("#profile_form").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
            url: "http://127.0.0.1:8000/api/profile/update",
            type: "POST",
            data: formData,
            headers: {'Authorization':localStorage.getItem('access_token')},
            success: function(data){
                if(data.status == 'true'){
                    $(".error").text("");
                    setTimeout(function(){
                        $(".result").text("")
                    },3500);
                    $(".result").text("User Updated Successfully");
                }else{
                    errorMessage(data);
                }
            }
            });
        });

        function errorMessage(message){
          $(".error").text("");
          $.each(message, function (key,value){
              $("."+key+"_err").text(value);
 
          });
        }

        //email verification
        $(document).on('click','.verify_email',function(){
            var email = $(this).attr('data-id');
            console.log(email);
            $.ajax({
            url: "http://127.0.0.1:8000/api/send-email/"+email,
            type: "GET",
            headers: {'Authorization': localStorage.getItem('access_token')},
            success: function(data){
                $('.result').text(data.message);
            }
            });
        });

    });
</script>