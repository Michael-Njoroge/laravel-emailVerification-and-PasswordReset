@include('../header')

<style>
  span{
    color: red;
  }
</style>

     <form id="register_form" >
        @csrf
        <div style="text-align: center;">
          <h1 style="text-align: center;">Sign Up</h1>
          <!-- <p>Please fill in this form to create an account.</p> -->
           <label for="email"><b>Name</b></label>
          <input type="text" name="name" id="name" placeholder="Enter name" >
          <br>
          <span class="error name_err"></span>
          <br><br> 

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

          <label for="psw"><b>Confirm Password</b></label>
          <input type="password" placeholder="Confirm Password" name="password_confirmation">
          <br>
          <span class="error password_confirmation_err"></span>
          <br><br> 

          <button type="submit" class="btn">Sign Up</button>
         </div>
      </form>
      <p class="result" style="text-align: center;"></p>

      <script type="text/javascript">
        $(document).ready(function(){
            $('#register_form').submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: "http://127.0.0.1:8000/api/register",
                type: "POST",
                data: formData,
                success:function(data){
                    console.log(data);
                    if(data.message){
                      $("#register_form")[0].reset();
                      $(".error").text("");
                      $(".result").text(data.message)
                    } else{
                      errorMessage(data);
                    } 
                }
            });
        });
        function errorMessage(message){
          $(".error").text("");
          $.each(message, function (key,value){
            if(key == 'password'){
              if(value.length > 1){
                $(".password_err").text(value[0]);
                $(".password_confirmation_err").text(value[1]);
              }else{
                if(value[0].includes('password confirmation')){
                  $(".password_confirmation_err").text(value);
                }else{
                  $(".password_err").text(value);
                }
              }
            }else{
              $("."+key+"_err").text(value);

            }
          })
        }
    });
  
    </script>

  