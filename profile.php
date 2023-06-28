<?php 
 session_start();

 if(!isset($_SESSION['userid'])){
     header('location:login.php');
 }   
    $app = "<script src='js/profile.js'></script>";
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
    <link rel="stylesheet" href="css/cart.css">

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
            <a href="index.php">HOME</a>
            <a href="index.php#ABOUT">ABOUT</a>
            <a href="menu.php">MENU</a>
            <a href="reserve.php">CUSTOMIZE</a>
            <a href="index.php#contact">CONTACT</a>
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
              <i class="fas fa-search" id="search" onclick="toggleSearchInput()"></i>
              <i class="fas fa-bars" id="menu-bar" onclick="toggleNavbar()"></i>
              <i class="fa fa-shopping-cart"onclick="showCart()"></i>
            </div>

            <div class="search" id="searchInput">
              <input type="search" placeholder="search...">
            </div>

         <div class="cart-panel" id="cartPanel">
  <div class="cart-header">
    <h2 class="cart-title">Shopping Cart</h2>
    <i class="fas fa-times" onclick="hideCart()"></i>
  </div>
  <ul id="cartItemsList"></ul>
  <div class="cart-footer">
    <div class="cart-total">Total: ₱<span id="cartTotal">0.00</span></div>
    <button class="checkout-button" onclick="checkout()">Checkout</button>
  </div>
</div>
    </header>
    <!-- header section end here  -->



  
    <div class="container" id="profile-app">
  <div class="col-md-6">
    <h3 class="text-light" style="font-size:35px; font-family:emoji;">USER PROFILE</h3>
    <form  @submit="fnupdateUser($event)">
      <input type="text"  class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>" disabled>
      <input type="text"  class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;" name="fullname" value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '' ?>" disabled>
      <input type="text" class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;" name="address" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>" disabled>
      <input type="text"  class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;" name="mobile" value="<?php echo isset($_SESSION['mobile']) ? $_SESSION['mobile'] : '' ?>" disabled>
      <input type="text"  class="form-control mb-4 text-light bg-dark" style="font-size:20px; font-family:emoji;" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>" disabled>
      <button class="btn btn-outline-success float-end mt-3 p-4 pt-4" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
      <button class="btn btn-outline-primary float-end mt-3 me-2 p-4 pt-4" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</button>
    </form>
  </div>

</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="profile-app">
        <form @submit.prevent="fnupdateUser($event)">
          <input type="text"  class="form-control mb-4"  style="font-size:20px; font-family:emoji;" name="username" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>">
          <input type="text"  class="form-control mb-4" style="font-size:20px; font-family:emoji;" name="fullname" value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '' ?>">
          <input type="text"  class="form-control mb-4" style="font-size:20px; font-family:emoji;" name="address" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>">
          <input type="text"  class="form-control mb-4" style="font-size:20px; font-family:emoji;" name="mobile" value="<?php echo isset($_SESSION['mobile']) ? $_SESSION['mobile'] : '' ?>">
          <input type="text"  class="form-control mb-4" style="font-size:20px; font-family:emoji;"name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>">
          <button type="submit" class="btn btn-primary" style="font-size:20px; font-family:emoji;">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Change Password Modal ----->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="change-password-form" @submit="changePassword($event)">
          <div class="mb-3">
            <label for="current-password" class="form-label" style="font-size:20px; font-family:emoji;">Current Password</label>
            <input type="password" id="current-password" class="form-control" style="font-size:20px; font-family:emoji;" name="current_password" required>
          </div>
          <div class="mb-3">
            <label for="new-password" class="form-label" style="font-size:20px; font-family:emoji;">New Password</label>
            <input type="password" id="new-password" class="form-control"  style="font-size:20px; font-family:emoji;" name="new_password" required>
          </div>
          <div class="mb-3">
            <label for="confirm-password" class="form-label" style="font-size:20px; font-family:emoji;">Confirm Password</label>
            <input type="password" id="confirm-password" class="form-control"  style="font-size:20px; font-family:emoji;" name="confirm_password" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary" style="font-size:20px; font-family:emoji;">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>





    <!-- custom js file  -->
    <script src="js/cart.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
<?php echo $app; ?>



</body>

</html>