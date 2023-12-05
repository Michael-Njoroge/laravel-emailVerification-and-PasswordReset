
<style>
  span{
    color: red;
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
        height: 350px;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transform: translateY(25%);   
        margin: 0 auto;    
        border-radius: 20px;         
    }
 
  
</style>

@if($errors->any())
<ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
</ul>
@endif

     <form method="post" >
        @csrf
        <div style="text-align: center;">
          <h1 style="text-align: center;">Reset Password</h1>
          <!-- <p class="heading">Please Reset Password</p> -->

          <input type="hidden" name="id" value="{{$user[0]['id']}}">
          <input type="password" placeholder="Enter New Password" name="password" id="password">
          <br>
          <span class="error password_err"></span>
          <br>
         
          <input type="password" placeholder="Enter Confirm Password" name="password_confirmation" id="password_confirmation">
          <br>
          <span class="error password_confirmation_err"></span>
          <br><br>
 
          <button type="submit" class="btn">Reset Password</button>
          </div>
 
      </form>
 
    </script>

  