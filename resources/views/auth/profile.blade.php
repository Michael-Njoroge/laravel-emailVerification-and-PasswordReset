@include('../header')

<style>
    .update
    {
        cursor: pointer;
        background-color: green;
        border-style: none;
        border-radius: 25px;
        padding: 5px 6px;
        width: 100%;
        color: #fff;
        font-size: 15px;
        font-weight: bold;
    }
  
    input
    {
        border-style: none;
        border-radius: 15px;
        padding: 5px 2px;
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
        height: 350px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 12px;
        transform: translateY(30%);   
        margin: 0 auto;    
        border-radius: 5px;         
    }

    .email_verify
    {
        text-align: center;
    }
</style>


<form action="">

<div class="email_verify">
    <h1>Hello, <span class="name"></span></h1>

    <p><b>Email:- <span class="email"></span> &nbsp; <span class="verify"></span> </b></p>
</div>
<input type="text" placeholder="Enter Name" name="email" id="name" required>
<br><br>
<input type="email" placeholder="Enter Email" name="email" id="email" required>
<br><br><br>
<button type="submit" class="update">Update Profile</button>
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