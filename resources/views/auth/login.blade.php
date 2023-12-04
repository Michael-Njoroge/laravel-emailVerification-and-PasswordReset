@include('../header')
 
<style>
  span, .result{
    color: red;
  }
  .heading{
    font-weight: bold;
  }
  .btn
    {
        cursor: pointer;
        background-color: green;
        border-style: none;
        border-radius: 15px;
        padding: 12px 6px;
        width: 90%;
        color: #fff;
        font-size: 15px;
        font-weight: bold;
        margin-bottom: 5px;
    }
  
    input
    {
        border-style: none;
        border-radius: 15px;
        padding: 12px 2px;
        background: #fff;
        margin: 2px;
        text-align: center;
        width: 90%;
        font-size: 18px;
        font-weight: bold;
        outline: none;
        
     }

    form
    {
        background: gainsboro;
        width: 500px;
        height: 400px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transform: translateY(25%);   
        margin: 0 auto;    
        border-radius: 20px;         
    }

    a{
      text-decoration: none;
      font-size: 16px;
      color: blue;
      font-weight: bold;
       width: 50px;
      padding: 2px 5px;
     }
    a:visited,a:active{
      text-decoration: none;
    }
    a:hover{
      text-decoration: underline;
    }
  
</style>

     <form id="login_form" >
        @csrf
        <div style="text-align: center;">
          <h1 style="text-align: center;">Sign In</h1>
          <p class="heading">Welcome Back, login to your account.</p>
 
          <input type="text" placeholder="Enter Email" name="email" id="email" autocomplete="off" >
          <br>
          <span class="error email_err"></span>
          <br>
         
          <input type="password" placeholder="Enter Password" name="password" id="password" >
          <br>
          <span class="error password_err"></span>
          <br>
 
          <button type="submit" class="btn">Sign In</button>
          <p>Dont have an account? <a href="{{route('registration')}}">Register</a></p>
         </div>

         
      <p class="result" style="text-align: center;"></p>

      </form>
      <script type="text/javascript">
        $(document).ready(function(){
            $('#login_form').submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: "http://127.0.0.1:8000/api/login",
                type: "POST",
                data: formData,
                success:function(data){
                     $(".error").text("");
                     if(data.status == 'false'){
                        $("#login_form")[0].reset();
                        $(".result").text(data.message);
                     }
                     else if(data.status == 'success'){
                        localStorage.setItem("access_token",data.authorization+" "+data.token);
                        window.open("/profile","_self");
                     }
                     else{
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
    });
  
    </script>

  