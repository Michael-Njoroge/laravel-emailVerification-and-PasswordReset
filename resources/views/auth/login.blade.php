@include('../header')
 
<style>
  span{
    color: red;
  }
</style>

     <form id="login_form" >
        @csrf
        <div style="text-align: center;">
          <h1 style="text-align: center;">Sign In</h1>
          <!-- <p>Please fill in this form to create an account.</p> -->
          <label for="email"><b>Email</b></label>
          <input type="email" placeholder="Enter Email" name="email" id="email" >
          <br>
          <span class="error email_err"></span>
          <br><br> 
         
          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" id="password" >
          <br>
          <span class="error password_err"></span>
          <br><br> 
 
          <button type="submit" class="btn">Sign In</button>
         </div>
      </form>
      <p class="result" style="text-align: center;"></p>

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
                    console.log(data);
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

  