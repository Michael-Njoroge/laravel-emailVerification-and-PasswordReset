<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SignIn</title>
</head>
 
<link rel="stylesheet" href="{{asset('../../../assets/style.css')}}">
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Styling the login page -->

<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat:400,500&display=swap');
body {
	font-family: Montserrat,Arial, Helvetica, sans-serif;
	background-color:#f7f7f7;
}
* {box-sizing: border-box}

/* Add padding to container elements */
.container {
    padding: 20px;
      width:500px;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
      border:1px solid #ccc;
      border-radius:10px;
      background:white;
  -webkit-box-shadow: 2px 1px 21px -9px rgba(0,0,0,0.38);
  -moz-box-shadow: 2px 1px 21px -9px rgba(0,0,0,0.38);
  box-shadow: 2px 1px 21px -9px rgba(0,0,0,0.38);
  }

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 12px 0;
  display: inline-block;
  border: none;
  background: #f7f7f7;
	font-family: Montserrat,Arial, Helvetica, sans-serif;
}
 
input[type=text]:focus, input[type=password]:focus, input[type=phone]:focus, select:focus {
  background-color: #ddd;
  outline: none;
}
 

/* Set a style for all buttons */
button {
  background-color: #0eb7f4;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
	font-size:16px;
	font-family: Montserrat,Arial, Helvetica, sans-serif;
	border-radius:10px;
}

button:hover {
  opacity:1;
}
 
</style>

<!-- End of styling the login page -->


<body>
    <form id="login_form" >
        @csrf
        <div class="container">
          <h1 style="text-align: center;">Sign In</h1>
          <!-- <p>Sign In to your account.</p> -->
         
          <div class="form-control "> 
          <label for="email"><b>Email</b></label>
          <input type="text" placeholder="Enter Email" name="email" id="email" >
          </div>

          <div class="form-control">
          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password" id="password" >
          </div>
 
          <div class="clearfix">
       
            <button type="submit" class="btn">Sign In</button>
          </div>
        </div>
      </form>
      
      <script src="{{asset('../../../assets/validate.min.js')}}"></script>

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
                    if(data.message){

                    }                
                }
            });
        });
    });
  
    </script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#login_form').validate({
            rules: {
                  
                email: {
                    required : true,
                }, 
                password: {
                    required : true,
                }, 
                
            },
            messages :{
               
                email: {
                    required : 'Email field is required',
                },
                password: {
                    required : 'Password field is required',
                },

            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-control').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>

</body>
</html>