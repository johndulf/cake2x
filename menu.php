<?php

session_start();

if (!isset($_SESSION["userid"])) {
    header("location:login.php");
}

// include "includes/header.php";
$app = "<script src='js/app.products.js'></script>";
$app = "<script src='js/app.reserved.js'></script>";
$fullname = isset($_SESSION["fullname"]) ? $_SESSION["fullname"] : "";
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel = "icon" href = "img/logo.png" type = "image/x-icon">
        <!-- <link rel="stylesheet" href="css/index.css"> -->
          <!-- <link rel="stylesheet" href="css/dashboard.css"> -->
    <title>Menu</title>
</head>
<body>
    
  <div  id="products-app" >
  <header class="header">
        <div class="logoContent">
            <a href="#" class="logo"><img src="img/logo.png" alt=""></a>
            <h1 class="logoName">CakeEace </h1>
        </div>

        <nav class="navbar">
            <a href="index.php">HOME</a>
            <a href="index.php">ABOUT</a>
            <a href="menu.php">MENU</a>
            <a href="reserve.php">RESERVE</a>
            <a href="index.php#contact">CONTACT</a>
            <div class="dropdown">
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

       <!-- <h2 class="products" style="color:yellow; font-family:emoji;">Menu</h2> -->
    <div >
      <h1 class="products" style="color:black; text-align:center; font-family:emoji;">Menu</h1>
      <div class="all-products">
         <div class="product" v-for="product in products">
            <img class="img-fluid" :src="'uploads/' + product.image"/>
            <div class="product-info">  {{ product.description }}
               <h4 class="product-title">{{ product.productname }}
               </h4>
               <p class="product-price"> P{{ product.price }}</p>
                <button class="btn btn-primary float-center m-1" style="margin-right:10px;" @click="fnGetProdcuts(product.id)"data-bs-toggle="modal" data-bs-target="#reserve" >Reserve</button>
            </div>
         </div>
       </div>
    
         <div class="modal fade" tabindex="-1" id="reserve">
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
                            <input class="form-control mb-2" type="number" name="price" id="price" :value="price" readonly>
                            <!-- <p>Price: &#8369;{{price}}</p> -->
                            <label for="quantity">Quantity:</label>
                            <input class="form-control mb-2" type="number" name="quantity" id="quantity" v-model="num">
                            <label for="total">Total:</label>
                            <input class="form-control mb-2" type="number" name="total" id="total" :value="price * num" readonly>
                            <!-- <p  name="total" id="total">Total : &#8369;{{price * num}}</p> -->
                            <input type="number" name="product_id" id="product_id" :value="productid" hidden>
                            <button  type="submit" class="btn btn-outline-success float-end mt-3"  >Reserve</button>
                            <button type="button" class="btn btn-outline-info float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
      </div>
      </div> 







    <!--Update Product -->
       <!-- <div class="modal fade" tabindex="-1" id="updatePro">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content p-4s">
                    <div class="modal-header">
                        <h5>Update Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="products-app" novalidate class="upPro" >
                        <form @submit="fnSave($event)">
                        <input class="form-control mb-2" required type="text" name="productname" placeholder="Product Name" v-model="productname" />
                        <textarea class="form-control mb-2" name="description" v-model="description" placeholder="Description"></textarea>
                        <input class="form-control mb-2" required type="number" name="quantity" placeholder="Quantity" v-model="quantity" />
                        <input class="form-control mb-2" required type="text" name="price" placeholder="Unit Price" v-model="price" />
                        <input class="form-control mb-2" type="file" name="productimage" />
        
                      
                

                      <button  type="submit" class="btn btn-success float-end mt-3">Update</button>
                      <button type="button" class="btn btn-outline-secondary float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
            </form>
                    </div>
                    
                  </div>
                </div>
            </div>
            
      </div>  
      </div>   -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    
   
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
<?php echo $app; ?>
 <script src="js/script.js"></script>

</body>
</html>
    
