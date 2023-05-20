<?php 
    $app = "<script src='../js/app.admin.js'></script>";
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
    <link rel="stylesheet" href="../css/s.css">
</head>
<style>
      body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background: repeating-radial-gradient(closest-side at 25px 35px, orange 15%, gold 40%);
    background-size:60px 60px;
    height: 200px;
  }
</style>
<body>  
<div id="register-app" class="login-box" >
    <div class="loginForm">
        <h2>Register New Account</h2>
<form @submit="fnSave($event)" class="reg">
     <div class="user-box">
   <div class="user-box">
    <input required type="text" name="username" v-model="username" />
     <label>Username</label>
</div>
      <div class="user-box">
    <input required type="password" name="password"  v-model="password" />
     <label>Password</label>
</div>
     <div class="user-box">
    <input required type="text" name="first_name" v-model="first_name" />
     <label>First Name</label>
</div>
<div class="user-box">
    <input required type="tel" name="last_name" v-model="last_name" />
     <label>Last Name</label>
</div>
 
        <button type="submit">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            Register
         </button>
           <button style="margin-left: 20px;"> 
            <a href="login.php">
            <span></span>
            <span></span>
            <span></span>
            <span></span>

           Log in
        </a>
         </button> 
</form>
</div>
</div>
<script src="../js/vue.3.js"></script>
<script src="../js/axios.js"></script>
 <script src="../js/script.js"></script>
<?php echo $app; ?>
</body>
</html>
    
