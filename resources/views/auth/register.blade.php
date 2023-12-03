@include('../header')

<style>
  span{
    color: red;
  }
  .result{
    color: green;
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
        height: 520px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transform: translateY(10%);   
        margin: 0 auto;    
        border-radius: 20px;  
        text-align: center;       
    }
</style>

     <form id="register_form" >
        @csrf
        <p class="result" style="text-align: center;"></p>
          <h1 style="text-align: center;">Sign Up</h1>
          <p class="heading">Please fill in this form to create an account.</p>
 
          <input type="text" name="name" id="name" placeholder="Enter name" >
          <br>
          <span class="error name_err"></span>
          <br>

          <input type="email" placeholder="Enter Email" name="email" id="email" >
          <br>
          <span class="error email_err"></span>
          <br>
         
          <input type="password" placeholder="Enter Password" name="password" id="password" >
          <br>
          <span class="error password_err"></span>
          <br>

          <input type="password" placeholder="Confirm Password" name="password_confirmation">
          <br>
          <span class="error password_confirmation_err"></span>
          <br>

          <button type="submit" class="btn">Sign Up</button>
 
      </form>

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
                      $(".result").text(data.message);
                      window.location.href = '/login';
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

  