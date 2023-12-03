@include('../header')
<h1>Hello, <span class="name"></span></h1>

<div class="email_verify">
    <p><b>Email:- <span class="email"></span> &nbsp; <span class="verify"></span> </b></p>
</div>

<form action="">
<input type="text" placeholder="Enter Name" name="email" id="name" required>
<br><br>
<input type="email" placeholder="Enter Email" name="email" id="email" required>
<br><br>
<input type="submit" value="Update Profile">
</form>

<script>
    $(document).ready(function(){
        $.ajax({
            url: "http://127.0.0.1:8000/api/profile",
            type: "GET",
            headers: {'Authorization': localStorage.getItem('access_token')},
            success: function(data){
                if(data.status == 'true'){
                    console.log(data);
                    $(".name").text(data.data.name);
                    $(".email").text(data.data.email);
                    $("#name").val(data.data.name);
                    $("#email").val(data.data.email);

                    if(data.data.email_verified_at == null || data.data.email_verified_at == ''){
                        $(".verify").html("<a href=''>Verify</a>");
                    }else{
                        $(".verify").text("Verified");
                    }
                }else{
                    alert(data.message);
                }
            }
        });
    });
</script>