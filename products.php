<?php 

session_start();

if(!isset($_SESSION['userid'])){
    header('location:login.php');
}
    
    // include "includes/header.php";
  $app = "<script src='js/app.products.js'></script>";
    $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/index.css">
        <link rel = "icon" href = "img/logo.png" type = "image/x-icon">
          <!-- <link rel="stylesheet" href="css/dashboard.css"> -->
    <title>Products</title>
</head>
<style>
       #wrapper{
        /* display: flex; */
    /* align-items: center; */
      margin: 0;
    padding: 0;
        font-family: emoji;
    background-size: cover;
         color:black;
    
    }
</style>
<body>
  <div  id="products-app" >
      <?php if($role == 2): ?>
 <div class="d-flex" id="wrapper" >
        <!--sidebar starts here-->

        <div class="bg-black" id="sidebar-wrapper">
            
        <div class="sidebar-heading text-center py-4 text-light fs-4 fw-bold text-uppercase border-bottom">
                <img src="images/admin.png" width="100" height="100" alt="logo" > ADMIN
            </div>

            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text active">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard 
                </a>
                <a href="userlist.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fa fa-user  me-2" aria-hidden="true"></i> User
                </a>
                <!-- <a href="" style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-user-tie me-2"></i> Seller
                </a> -->
                <a href="customize.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Customize
                </a>
                <a href="reservation.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Reserve
                </a>  
                   <a href=""  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Products
                </a> 
                <a href="logout.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold" id="btn_logout">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                </a>
            </div>

        </div>

        <!--sidebar ends here-->

       <div id="page-content-wrapper">

           
                <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                    <div class="d-flex align-item-center">
                        <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                        <h2 class="fs-2 m-0">Menu</h2>
                    </div>    
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>   
                    
                </nav>


                <div class="container-fluid row my-5" id="user">
                    <div class="input-group rounded row">
                        <h3 class="fs-4 mb-3 col">List of Product</h3>
                        <div class="col-12 col-lg-3">  
                            <div class="col mt-2 mb-3">
                                <input type="search" v-model="search" @input="searchUser(search)" class="form-control" placeholder="Search Products">
                            </div>
                        </div>
                    </div>

    
     <!-- Add Product -->
  <div class="container justify-content-sm-start my-2 mb-2">
                        <button  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">Add Product</button>
                    </div>
                              
                                <div class="modal fade" tabindex="-1" id="addproduct">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content p-4s">
                    <div class="modal-header">
                        <h5>Add PRODUCT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body p-4" id="products-app" >
                        <form @submit="fnSave($event)">
                        <input class="form-control mb-2" required type="text" name="productname" placeholder="Product Name" v-model="productname" />
                        <textarea class="form-control mb-2 " name="description" v-model="description" placeholder="Description"></textarea>
                        <input class="form-control mb-2" required type="number" name="quantity" placeholder="Quantity" v-model="quantity" />
                        <input class="form-control mb-2" required type="text" name="price" placeholder="Unit Price" v-model="price" />
                        <input class="form-control mb-2" type="file" name="productimage" />
                        
    
                            <button type="submit" class="btn btn-info float-end mt-3">Add</button>
                            <button type="button" class="btn btn-outline-secondary float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
                        </form> 
                    </div>
                    
                  </div>
                </div>
            </div>
                   
                
    

        <div class="col">
  <table class="table bg-white rounded shadow-sm table-hover">
    <thead align="center">
      <tr>
        <th>Image</th>
        <th>Product Name</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="product in products" :key="product.productid">
        <td>
          <img style="width:70px; height:45px; display: block; margin-left: auto; margin-right: auto;" :src="'uploads/' + product.image" />
        </td>
        <td>{{ product.productname }}</td>
        <td>{{ product.description }}</td>
        <td>{{ product.quantity }}</td>
        <td>{{ product.price }}</td>
        <!-- <td>{{ product.quantity === 0 ? 'Sold' : 'Available' }}</td> -->
     <td>
  <span v-if="product.quantity === 0" style="font-weight: bold; color: red; font-size: 25px; font-family: emoji;">Sold</span>
  <span v-else style="font-weight: bold; color: black;">Available</span>
</td>


        <td>
          <button class="btn btn-outline-success float-end mt-3" @click="fnGetProdcuts(product.productid)" data-bs-toggle="modal" data-bs-target="#updatePro">Update</button>
          <button class="btn btn-outline-danger float-end mt-3 me-2" @click="DeleteProducts(product.productid)">Delete</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>


    <!--Update Product -->
       <div class="modal fade" tabindex="-1" id="updatePro">
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
                        <input class="form-control mb-2" type="file" name="productimage" hidden/>
        
                      
                

                      <button  type="submit" class="btn btn-success float-end mt-3">Update</button>
                      <button type="button" class="btn btn-outline-secondary float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
            </form>
                    </div>
                    
                  </div>
                </div>
            </div>
            
      </div>  
  </div>
      </div>  
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

   <?php endif ?>
<script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
<?php echo $app; ?>
 <script src="js/script.js"></script>

</body>
</html>
    