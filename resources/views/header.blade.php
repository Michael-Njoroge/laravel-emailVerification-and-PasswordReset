<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test App</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>

<button class="logout">Logout</button>
  
<script>
    var token = localStorage.getItem('access_token');

    if( window.location.pathname == '/register' || window.location.pathname == '/login')
    {

        if(token != null){
            window.location.href = '/profile';
        }

        $(".logout").hide();

    }
    else{

        if(token == null){
            window.location.href = '/login';
        }

    }

    //logout user
    $(".logout").click(function(){
        $.ajax({
                url: "http://127.0.0.1:8000/api/logout",
                type: "GET",
                headers: {
                    'Authorization':localStorage.getItem('access_token')
                },
                success:function(data){
                    if(data.status == 'true')
                    {
                        localStorage.removeItem('access_token');
                        window.location.href = 'login'
                    }
                    else{
                        alert(data.message)
                    }
                }
            });
    });
</script>

</body>
</html>