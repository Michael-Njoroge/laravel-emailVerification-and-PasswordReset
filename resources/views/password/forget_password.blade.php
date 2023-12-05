<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
  span{
    color: red;
  }
  .result{
    color: red;
    position: absolute;
    transform: translateX(3%);
    padding: 2px;
    left: 25%;
    font-size: 20px;
    top: 12rem;
    }
  .success{
    color: green;
    text-align: center;
    font-size: 16px;
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

    .form
    {
        background: gainsboro;
        width: 500px;
        height: 260px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transform: translateY(65%);   
        margin: 0 auto;    
        border-radius: 20px;   
      }
 
  
</style>

 <div class="form">
 <p class="result"></p>
 <p class="success"></p>

     <form id="forgetForm" >
        @csrf
        <div style="text-align: center;">
          <h1 style="text-align: center;">Forget Password</h1>
          <!-- <p class="heading">Please Reset Password</p> -->

           <input type="text" placeholder="Enter Your Email" name="email" id="email">
          <br>
          <span class="error email_err"></span>
          <br>
          
          <button type="submit" class="btn">Submit</button>
          </div>
 
      </form>
</div>

 <script type="text/javascript">
    $(document).ready(function(){

    $('#forgetForm').submit(function(event){
      event.preventDefault();

      var formData = $(this).serialize();

      $.ajax({
        url: "http://127.0.0.1:8000/api/forget-password",
        type: "POST",
        data: formData,
        success: function(data){
          console.log(data);

          if(data.status == 'true')
          {
            $("#forgetForm")[0].reset();
            $(".success").text(data.message);
            setTimeout(function()
            {
              $(".success").text("")
            },3000);

           }
           else if(data.status == 'false')
           {
             $(".result").text(data.message);
            setTimeout(function()
            {
              $(".result").text("")
            },3000);
            }
            else{
              errorMessage(data);
              setTimeout(function()
            {
              $(".error").text("");
            },3000);
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


  