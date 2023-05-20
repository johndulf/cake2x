<?php 

session_start();

if(!isset($_SESSION['userid'])){
    header('location:login.php');
}
    $app = "<script src='js/app.register.js'></script>";
    // $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
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
    <link rel="stylesheet" href="css/style.css">
    <link rel = "icon" href = "img/logo.png" type = "image/x-icon">
    <title>User list</title>
</head>
<style>
    #wrapper{
        /* display: flex; */
    /* align-items: center; */
      margin: 0;
    padding: 0;
        font-family: emoji;
    background-size: cover;
         color:white;
    
    }
</style>
<body>
<?php if($role == 1): ?>
        <div id="register-app">
  <div class="d-flex" id="wrapper">
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
                <a href="#"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Customize
                </a>
                    <a href="reservation.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Reserve
                </a>  
                   <a href="products.php"  style="font-size:25px" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
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
                        <h2 class="fs-2 m-0">Userlist</h2>
                    </div>    
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>   
                    
                </nav>


                <div class="container-fluid row my-5" id="user">
                    <div class="input-group rounded row">
                        <h3 class="fs-4 mb-3 col">List of User</h3>
                        <div class="col-12 col-lg-3">  
                            <div class="col mt-2 mb-3">
                            <input type="search" v-model="search" @input="searchUser(search)" class="form-control" placeholder="Search User">

                            </div>
                        </div>
                    </div>


          
         
              
            <div class="col">
            <table class="table bg-white rounded shadow-sm  table-hover ">
               <thead align="center">
        <tr>
            <th>Fullname</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Mobile Number </th>
            <th>Date Created</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    
    

        <tr v-for="user in users">
            <td>{{ user.fullname }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.address }}</td>
             <td>{{ user.mobile }}</td>
            <td>{{ user.datecreated }} </td>
            <td>{{ user.counterlock >= 3 ? 'Account Locked' : 'Active' }}</td>
            <td>
            <button class="btn btn-outline-success float-end mt-3" @click="fnGetUsers(user.userid)"  data-bs-toggle="modal" data-bs-target="#updateSt">Update</button>
                <button class="btn btn-outline-danger float-end mt-3 me-2" @click="DeleteUser(user.userid)" id="delete"> Delete</button> 

                <a v-if="user.counterlock >= 3" href="#" @click="fnUnlockAccount(user.userid)">Unlock</a>
            </td>
        </tr>
    </tbody>
</table>
</div>

        <!--Update User -->
       <div class="modal fade" tabindex="-1" id="updateSt">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content p-4s">
                    <div class="modal-header">
                        <h5>Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="register-app" >
                    <form @submit="fnSave($event)" >
                <input required type="text" name="fullname" placeholder="Fullname" v-model="fullname"  class="form-control mb-2"/>
                <input required type="text" name="username" placeholder="Username" v-model="username"  class="form-control mb-2"/>
                <input required type="email" name="email" placeholder="Email" v-model="email"  class="form-control mb-2"/>
                <input required type="text" name="address" placeholder="Address" v-model="address" class="form-control mb-2"/>
                <input required type="number"  name="mobile" placeholder="Mobile Number" v-model="mobile" class="form-control mb-2"/>
                <input type="password" name="password" placeholder="Password" v-model="password" class="form-control mb-2" hidden/>


                      <button  type="submit" class="btn btn-outline-success float-end mt-3" id="update"  >Update</button>
                      <button type="button" class="btn btn-outline-info float-end mt-3 me-2" data-bs-dismiss="modal">Cancel</button>
            </form>
                    </div>
                    
                  </div>
                </div>
            </div>
            
      </div>
      </div>
      </div>
      </div>  
      <?php endif ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/vue.3.js"></script>
<script src="js/axios.js"></script>
 <script src="js/script.js"></script>
<?php echo $app; ?>
</body>
</html>

       
    
