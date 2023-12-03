 
<style>
 
    a
    {
        cursor: pointer;
        background-color: green;
        border-style: none;
        border-radius: 15px;
        padding: 12px 6px;
        width: 100%;
        color: #fff;
        font-size: 15px;
        font-weight: bold;
        margin-top: 32px; 
        text-decoration: none; 
        text-align: center;
        justify-content: center;
        align-items: center;

    }
    a:visited{
        text-decoration: none; 
    }
 
    form
    {
        background: gainsboro;
        width: 500px;
        height: 180px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 12px;
        transform: translateY(50%);   
        margin: 0 auto;    
        border-radius: 20px;         
    }
 
</style>


<form action="">

<p class="result"></p>

     <h1>Email Verified Successfully</h1>
  
<a href="{{route('profile.view')}}">Go Back</a> 

</form>
 