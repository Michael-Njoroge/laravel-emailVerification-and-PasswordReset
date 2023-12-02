<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  
<script>
    var token = localStorage.getItem('access_token');

    if( window.location.pathname == '/register' || window.location.pathname == '/login')
    {

        if(token != null){
            window.location.href = '/profile';
        }

    }
    else{

        if(token == null){
            window.location.href = '/login';
        }

    }
</script>

</body>
</html>