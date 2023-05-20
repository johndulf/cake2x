<?php 

session_start();

if(!isset($_SESSION['userid'])){
    header('location:login.php');
}
    // $app = "<script src='js/app.register.js'></script>";
    // $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
    // $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="css/style.css"> -->
      <link rel="stylesheet" href="style.css">
       <!-- <link rel="stylesheet" href="bootstrap.css"> -->
       <link rel = "icon" href = "img/logo.png" type = "image/x-icon">
	<title>Customize</title>
</head>
<style>
    body{
        display: flex;
    /* align-items: center; */
    justify-content: center;
    flex-wrap: wrap;
  height: 100vh;
      margin: 0;
    padding: 0;
    font-family: emoji;
    background-size: cover;
         background: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.7)), url('images/cakess.jpg');
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
            <a href="index.php">ABOUT</a>
            <a href="menu.php">MENU</a>
            <a href="reserve.php">RESERVE</a>
            <a href="#contact">CONTACT</a>
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

  <div id="products-app" style="margin-top:150px;">
        <div class="container">
            <div class="row">
                <h1 style="color:white; font-family:emoji; text-shadow: 2px 1px #21201e; ">Customize Cake</h1>
                <div class="col-md-12">
                </div>
                
                <div class="col-md-12 p-5">
                    
                    <form @submit.prevent="fnSave($event)" style="font-size:25px;">
                    <div class="form-group">
                    <input class="mb-4 p-3" required type="date" name="date" placeholder="date" style="font-size:15px; font-family:emoji;" v-model="date" />
                    <input class="mb-4 p-3" required type="number" name="mobile" placeholder="Phone Number" style="font-size:15px; font-family:emoji;" v-model="mobile" />
                </div>
                        <textarea class="form-control mb-4" name="Suggestion"  placeholder="Suggestion"  style="font-size:15px; font-family:emoji;"v-model="suggestion"></textarea>
                        <textarea class="form-control mb-4" name="message" placeholder="Message" style="font-size:15px; font-family:emoji;" v-model="message"></textarea>
                        <select name="size" id="size" class="form-control mb-4" style="font-size:15px; font-family:emoji;" v-model="size">
                            <option selected disabled hidden>Size</option>
                          <option value="250" >Small : &#8369;250.00</option>
                          <option value="350" >medium : &#8369;350.00</option>
                          <option value="450">Large : &#8369;450.00</option>
                        </select>
                        <select name="flavor" id="flavor" class="form-control mb-4" style="font-size:15px; font-family:emoji;" v-model="flavor">
                            <option selected disabled hidden>Flavor</option>
                          <option value="Cookies" >Cookies</option>
                          <option value="Chocolate" >Chocolate </option>
                          <option value="StrawBerry">StrawBerry </option>
                          <option value="Banana" >Banana </option>
                          <option value="Coffee" >Coffee </option>
                          <option value="Others"> Others </option>
                        </select>
                        <input class="form-control mb-4" required type="number" name="quantity" placeholder="Quantity" style="font-size:15px; font-family:emoji;" v-model="quantity"/>
                        <!-- <input class="form-control mb-4" required type="text" name="price" placeholder="Unit Price" v-model="price" /> -->
                        <input class="form-control mb-4" type="file" name="productimage" style="font-size:15px; font-family:emoji;"/>
                        <button class="btn btn-primary btn-lg" type="submit"style="font-size:15px; font-family:emoji;"  >Customize</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
              <script src="css/css.js"></script>
              <script src="js/axios.js"></script>
              <script src="js/vue.3.js"></script>
              <script src="js/app.message.js"></script>
</body>
</html>