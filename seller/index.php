<?php 
    
    $app = "<script src='js/app.products.js'></script>";
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
	 <link rel="stylesheet" href="css/s2.css">
	<title>Index</title>
</head>
<style>
  .headline {
  width: 100%;
  height: 100vh;
  min-height: 350px;
  background: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.7)), url('img/back.png');
  background-size: cover;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.all-products{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

.product{
    overflow: hidden;
    background: whitesmoke;
    color: #21201e;
    text-align: center;
    width: 240px;
    height: 400px;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 1.2rem;
    margin: 2rem;
}

.product .product-title, .product .product-price{
    font-size: 18px;
}

.product:hover img{
    scale:  1.1;
}

.product:hover {
    box-shadow: 5px 15px 25px #eeeeee;
}

.product img {
    height: 200px;
    margin: 1rem;
    transition: all 0.3s;
}

.product button:link, .product button:visited{
    color: #ececec;
    display: inline-block;
    text-decoration: none;
    background-color: #2c3e50;
    padding: 1.2rem 3rem;
    border-radius: 1rem;
    margin-top: 1rem;
    font-size: 14px;
    transition: all 0.2s;
}

.product button:hover{
    transform: scale(1.1);
}


  </style>
<body>
		<div class="page-wrapper">
 <div class="nav-wrapper">
  <div class="grad-bar"></div>
  <nav class="navbar">
    <img src="" alt="Logo">
    <div class="menu-toggle" id="mobile-menu">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
    <ul class="nav no-search">
      <li class="nav-item"><a href="#">Home</a></li>
      <li class="nav-item"><a href="#">About</a></li>
      <li class="nav-item"><a href="#">Menu</a></li>
      <li class="nav-item"><a href="#">Reserve</a></li>
      <li class="nav-item"><a href="login.php" class="m-3">Log In</a></li>
        <!-- <li class="nav-item"><a href="#">Contact Us</a></li> -->
<!--       <i class="fas fa-search" id="search-icon"></i>
      <input class="search-input" type="text" placeholder="Search.."> -->
    </ul>
  </nav>
  </div>
  <section class="headline">
    <h1>Responsive Navigation</h1>
    <p>Using CSS grid and flexbox to easily build navbars!</p>
  </section>
    <h1 style="color: black;" class="m-3">ABOUT</h1>
  <section class="features">
    <div class="feature-container">
      <img src="https://cdn-images-1.medium.com/max/2000/1*HFAEJvVOq4AwFuBivNu_OQ.png" alt="Flexbox Feature">
      <h2>Flexbox Featured</h2>
      <p>This pen contains use of flexbox for the headline and feature section! We use it in our mobile navbar and show the power of mixing css grid and flexbox.</p>
    </div>
    <div class="feature-container">
      <img src="https://blog.webix.com/wp-content/uploads/2017/06/20170621-CSS-Grid-Layout-710x355-tiny.png" alt="Flexbox Feature">
      <h2>CSS Grid Navigation</h2>
      <p>While flexbox is used for the the mobile navbar, CSS grid is used for the desktop navbar showing many ways we can use both.</p>
    </div>
    <div class="feature-container">
      <img src="https://www.graycelltech.com/wp-content/uploads/2015/06/GCT-HTML5.jpg" alt="Flexbox Feature">
      <h2>Basic HTML5</h2>
      <p>This pen contains basic html to setup the page to display the responsive navbar.</p>
    </div>
  </section>
</div>
      <div  id="products-app" >
     <h2 class="products">Menu</h2>
      <div class="all-products">
         <div class="product" v-for="product in products">
            <img class="img-fluid" :src="'uploads/' + product.image"/>
            <div class="product-info">  {{ product.description }}
               <h4 class="product-title">{{ product.productname }}
               </h4>
               <p class="product-price" style="color: black">{{ product.price }}</p>
                            <button class="btn btn-primary float-center m-1" style="margin-right:10px;" @click="">Reserve</button>


            </div>
         </div>
       </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script src="css/css.js"></script>
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
<?php echo $app; ?>
 <script src="js/script.js"></script>

</body>
</html>