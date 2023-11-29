<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SignUp</title>
</head>

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
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f7f7f7;
	font-family: Montserrat,Arial, Helvetica, sans-serif;
}
 
input[type=phone] {
  width: 81%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f7f7f7;
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

/* Change styles for signup button on extra small screens */
@media screen and (max-width: 300px) {
  .signupbtn {
     width: 100%;
  }
}
</style>

<!-- End of styling the login page -->


<body>
    <form id="register_form" >
        @csrf
        <div class="container">
          <h1 style="text-align: center;">Sign Up</h1>
          <!-- <p>Please fill in this form to create an account.</p> -->
         
          <label for="email"><b>Name</b></label>
          <input type="text" name="name"  class="form-group" placeholder="Enter name" >

          <label for="email"><b>Email</b></label>
          <input type="text" placeholder="Enter Email" name="email"  class="form-group">
          
          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="password"  class="form-group">

          <label for="psw"><b>Confirm Password</b></label>
          <input type="password" placeholder="Confirm Password" name="password_confirmation">
         
          <div class="clearfix">
      
            <button type="submit" class="btn">Sign Up</button>
          </div>
        </div>
      </form>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script src="{{asset('backend/assets/code/validate.min.js')}}"></script>

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
                
                }
            });
        });
    });
        $(document).ready(function (){
        $('#register_form').validate({
            rules: {
               name: {
                    required : true,
                }, 
                email: {
                    required : true,
                }, 
                password: {
                    required : true,
                }, 
                
                
            },
            messages :{
               name: {
                    required : 'Name field is required',
                }, 
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
                element.closest('.form-group').append(error);
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