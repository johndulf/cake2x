<?php 
 session_start();

 if(!isset($_SESSION['userid'])){
     header('location:login.php');
 }   
    $app = "<script src='js/app.products.js'></script>";
    $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
    $mobile = isset($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CakeEace</title>

    <!-- cdn icon link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file  -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">

      <link rel = "icon" href = "img/logo.png" type = "image/x-icon">

</head>
<style>
    body{
     min-height: 100vh;
    display: flex;
    align-items: center;
    background:linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,15.30)), url(images/bg_1.jpg) no-repeat;
    background-size: cover;
    background-position: center center;
    }
</style>
<body>

    <!-- header section start here  -->
    <header class="header">
        <div class="logoContent">
            <a href="#" class="logo"><img src="img/logo.png" alt=""></a>
            <h1 class="logoName">CakeEace </h1>
        </div>

        <nav class="navbar">
            <a href="indexx.php">HOME</a>
            <a href="indexx.php">ABOUT</a>
            <a href="menu.php">MENU</a>
            <a href="reserve.php">RESERVE</a>
            <a href="indexx.php">CONTACT</a>
            <div class="dropdown">
  <a class="dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
  Account
</a>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
  </ul>
</div>
        </nav>

        <div class="icon">
            <i class="fas fa-search" id="search"></i>
            <i class="fas fa-bars" id="menu-bar"></i>
        </div>

        <div class="search">
            <input type="search" placeholder="search...">
        </div>
    </header>
    <!-- header section end here  -->



  
    
    <div class="container">
                <div class="col-md-6">
                       <h3 class="text-light" style="font-size:35px; font-family:emoji;">USER PROFILE</h3>
                <form> 
            <h3 class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;" > Username: <?php echo $username; ?></h3>
            <h3 class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;"> FULLNAME: <?php echo $fullname; ?></h3>
            <h3 class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;"> ADDRESS:<?php echo $address; ?></h3>
            <h3 class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;"> MOBILE:<?php echo $mobile; ?></h3>
            <h3 class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;">EMAIL:<?php echo $email; ?></h3>
            
            <!-- <button class="btn btn-outline-success float-end mt-3 p-4 pt-4" @click="fnGetUsers(user.userid)"  data-bs-toggle="modal" data-bs-target="#updateSt">Edit</button> -->
           </form>
           </div>
            </div>

  

        




    <!-- custom js file  -->
    <script src="css/css.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="css/css.js"></script>
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
<?php echo $app; ?>
 <script src="js/script.js"></script>


</body>

</html>