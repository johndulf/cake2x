<?php 
    
    $app = "<script src='js/app.products.js'></script>";
    $app = "<script src='js/app.reserved.js'></script>";
    // $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
    // $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
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
<body>
  <div id="products-app" >
  <header class="header">
        <div class="logoContent">
            <a href="#" class="logo"><img src="img/logo.png" alt=""></a>
            <h1 class="logoName">CakeEace </h1>
        </div>

                  <nav class="navbar" id="navbar">
              <a href="#home">HOME</a>
              <a href="#ABOUT">ABOUT</a>
              <a href="menu.php">MENU</a>
                   <a href="reserve.php">CUSTOMIZE</a>
              <a href="#contact">CONTACT</a>
              <div id="accountDropdown" v-if="isLoggedIn" class="dropdown">
                <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Account
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </div>
              <div v-else>
                <a href="login.php">LOGIN</a>
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


    <!-- home section start here  -->
    <section class="home" id="home">
        <div class="homeContent">
            <h2>Delicious Cake for Everyone </h2>
            <p>Unang Kagat Diabetes Agad</p>
            <div class="home-btn">
                <a href="reserve.php"><button>Customize</button></a>
            </div>
        </div>
    </section>

    <!-- home section end here  -->

  
     <!--   about section  start here  -->
    <h1 style="color: black; background-color: white; text-align: center; font-size:35px;" class="m-3">ABOUT</h1>
  <section class="features" id="ABOUT">
    <div class="feature-container">
      <img src="images/menu1.jpg" alt="Flexbox Feature">
      <h2>Welcome to our CakeEace shop</h2>
      <p>where every moment is a celebration of sweetness and indulgence. Nestled in the heart of the city, our cake shop is a haven for cake enthusiasts, offering a tantalizing array of delectable treats that will leave you craving for more.</p>
    </div>
    <div class="feature-container">
      <img src="images/menu5.jpg" alt="Flexbox Feature">
      <h2>Core</h2>
      <p>We understand that everyone has different preferences and dietary requirements, which is why we also offer a range of options to cater to various needs. Our collection includes vegan, gluten-free, and sugar-free cakes, ensuring that everyone can delight in the goodness of our creations</p>
    </div>
    <div class="feature-container">
      <img src="images/menu6.jpg" alt="Flexbox Feature">
      <h2>Values</h2>
      <p>At our cake shop, we believe that presentation is just as important as taste. Each cake is skillfully decorated with intricate designs, handcrafted sugar flowers, and personalized messages, making them perfect for birthdays, weddings, anniversaries, or any special occasion worth celebrating. Our team is always ready to collaborate with you to bring your vision to life, creating a custom cake that reflects your unique style and tastes.</p>
    </div>

  </section>

    <!--  about  section end here  -->

      <!-- product section start here  -->



                     <div>
              <h1 class="products" style="color:black; text-align:center; font-family:emoji;">Menu</h1>
              <div class="all-products">
                <div class="product" v-for="product in products">
                  <div class="image-container">
                    <img class="img-fluid" :src="'uploads/' + product.image" />
                  </div>
                  <div class="product-info">
                    {{ product.description }}
                    <h4 class="product-title">{{ product.productname }}</h4>
                    <p class="product-price">Stock: {{ product.quantity }}</p>
                    <p class="product-price">₱{{ product.price }}</p>

                    <div v-if="product.quantity > 0">
                      <button class="btn btn-primary float-center p-4 m-1" style="margin-right:10px; border:1px solid skyblue; " @click="fnGetProdcuts(product.id)" data-bs-toggle="modal" data-bs-target="#reserve">Reserve</button>
                      <button class="fa fa-shopping-cart text-black bg-transparent" style="margin-left:20px; font-size:20px;" data-bs-toggle="modal" data-bs-target="#addtoCart"></button>
                    </div>
                    <div v-else>
                      <div class="product-sold">
                        <p>Sold</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

       <!-- product section end here  -->

       <div class="dialog">
        <div v-if="isLoggedIn" class="modal fade" tabindex="-1" id="reserve">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4s">
                    <div class="modal-header">
                        <h5>Reserve</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form @submit.prevent="fnReserve($event)">
                            <p>{{productname}}</p>
                            <p>{{description}}</p>
                            <label for="sizes">Sizes</label>
                            <select  name="sizes" id="size" class="form-control mb-2" v-model="sizes" >
                                <!-- <option value="size" hidden selected>Size</option> -->
                                <option value="small" >Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                            <label for="price">Price:</label>
                            <input class="form-control mb-2 text-warning" type="number" name="price" id="price" :value="price" readonly>
                            <!-- <p>Price: &#8369;{{price}}</p> -->
                            <label for="quantity">Quantity:</label>
                            <input class="form-control  mb-2" type="number" name="quantity" id="quantity" v-model="num">
                            <label for="total">Total:</label>
                            <input class="form-control mb-2" type="number" name="total" id="total" :value="price * num" readonly>
                            <!-- <p  name="total" id="total">Total : &#8369;{{price * num}}</p> -->
                            <input type="number" name="product_id" id="product_id" :value="productid" hidden>
                            <button  type="submit" class="button btn btn-success float-end mt-3"  >Reserve</button>
                            <button type="button" class="button btn btn-info float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="modal fade" tabindex="-1" id="reserve">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4s">
                        <div class="modal-header">
                            <h5>Please <a href="login.php">Log In</a> to continue</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      </div>
      </div> 
</div>

  

             <!--Services-->

    <div class="services" id="Services">
  <h1>Services</h1>
  <div class="services_cards">
    <div class="services_box">
      <i class="fas fa-birthday-cake"></i>
      <h3>Custom Cakes</h3>
      <p>
        We specialize in creating delicious custom cakes for any occasion, personalized to your preferences.
      </p>
    </div>

    <div class="services_box">
      <i class="fas fa-certificate"></i>
      <h3>High-Quality Ingredients</h3>
      <p>
        We use only the finest and freshest ingredients to bake our cakes, ensuring a delightful and flavorful experience.
      </p>
    </div>

  <div class="services_box">
      <i class="fa-solid fa-truck"></i>
      <h3>Fast Delivery</h3>
      <p>
        Enjoy our speedy delivery service, ensuring that your cake arrives fresh and on time for your special occasion.
      </p>
    </div>
  </div>
</div>

              
                <!-- footer section start here  -->

                <footer class="footer" id="contact">
                    <div class="box-container">
                        <div class="mainBox">
                            <div class="content">
                                <!-- <a href="#"><img src="img/cake1.png" alt=""></a> -->
                            </div>

                        </div>
                        <div class="box">
                            <h3>Quick link</h3>
                            <a href="#"> <i class="fas fa-arrow-right"></i>Home</a>
                            <a href="#"> <i class="fas fa-arrow-right"></i>ABOUT</a>
                            <a href="#"> <i class="fas fa-arrow-right"></i>MENU</a>


                        </div>
                        <div class="box">
                              <h3>Extra link</h3>
                            <a href="profile.php"> <i class="fas fa-arrow-right"></i>Account info</a>
                            <a href="menu.php"> <i class="fas fa-arrow-right"></i>Reserve item</a>
                            <a href="reserve.php"> <i class="fas fa-arrow-right"></i>Customize Item</a>
                            <!-- <a href="#"> <i class="fas fa-arrow-right"></i>payment method</a> -->
                            <!-- <a href="#"> <i class="fas fa-arrow-right"></i>our  services</a> -->
                        </div>
                        <div class="box">
                            <h3>Contact Info</h3>
                            <a href="#"> <i class="fas fa-phone"></i>+9322459152</a>
                            <a href="#"> <i class="fas fa-envelope"></i>Jej@gmail.com</a>
                               
                        </div>

                    </div>
                    <div class="share">
                        <a href="#" class="fab fa-facebook-f"></a>
                        <a href="#" class="fab fa-twitter"></a>
                        <a href="#" class="fab fa-instagram"></a>
                        <a href="#" class="fab fa-linkedin"></a>
                        <a href="#" class="fab fa-pinterest"></a>
                    </div>
                    <div class="credit">
                        created by <span>Team Jej </span> |all rights reserved 2023! 
                    </div>
                </footer>
              </div>

    <!-- custom js file  -->

         <script src="js/cart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/vue.3.js"></script>
        <script src="js/axios.js"></script>
        <?php echo $app; ?>

</body>

</html>