<?php 
    $app = "<script src='js/app.seller.js'></script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
       <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/s.css">
</head>
<body>  
<div id="sellerregister-app" class="login-box" >
    <div class="loginForm">
        <h2>SIGN UP FOR SELLER</h2>
<form @submit="fnSaveSeller($event)">
     <div class="user-box">
    <input required type="text" name="fullname" v-model="fullname" />
    <label>Fullname</label>
</div>
   <div class="user-box">
    <input required type="text" name="username" v-model="username" />
     <label>Username</label>
</div>
      <div class="user-box">
    <input required type="password" name="password"  v-model="password" />
     <label>Password</label>
</div>
     <div class="user-box">
    <input required type="text" name="address" v-model="address" />
     <label>Address</label>
</div>
<div class="user-box">
    <input required type="tel" name="mobile" v-model="mobile" />
     <label>Mobile Number</label>
</div>
  <div class="user-box">
    <input required type="email" name="email" v-model="email" />
     <label>Email</label>
</div>
 <!--      <input required type="text" name="address" placeholder="Address" v-model="address" /><br>
       <input required type="text" name="mobile" placeholder="MobileNo" v-model="mobile" /><br>  -->
        <button type="submit">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Register
         </button>
          <button style="margin-left: 20px;"> 
            <a href="reg.php">
            <span></span>
            <span></span>
            <span></span>
            <span></span>

           Customer Register
        </a>
         </button>
</form>
</div>
</div>
<?php include "includes/footer.php"; ?>
    
