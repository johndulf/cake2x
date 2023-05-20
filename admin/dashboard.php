<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <title>Dashboard</title>
</head>
<body>
  <div id="students-app">
 <div class="d-flex" id="wrapper">
        <!--sidebar starts here-->

        <div class="bg-black" id="sidebar-wrapper">
            
            <div class="sidebar-heading text-center py-4 text-light fs-4 fw-bold text-uppercase border-bottom">
                <img src="../img/admin.png" width="100" height="100" alt="logo" > ADMIN
            </div>

            <div class="list-group list-group-flush my-3">
                <a href="dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text active">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard 
                </a>
                <a href="user.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fa fa-user  me-2" aria-hidden="true"></i> User
                </a>
                <a href="seller.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-user-tie me-2"></i> Seller
                </a>
                 <a href="../Admin/Receipt.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Message
                </a> 
                   <a href="../Admin/Receipt.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="fas fa-receipt me-2"></i> Products
                </a> 
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold" id="btn_logout">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                </a>
            </div>

        </div>

        <!--sidebar ends here-->

        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-black bg-transparent py-4 px-4">
                
                <div class="d-flex align-item-center">
                    <h2 class="fs-2 m-0">UserList</h2>
                </div>    
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>    
            </nav>

             <div class="container-fluid px-4" >
                

                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2" id="student">User</h3>                               

                                
                            </div>
                            <i class="fa fa-users fs-1 text-info bg-black border rounded-full secondary-bg p-3" aria-hidden="true"  ></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2" id="fees">Seller</h3>                                
                          
                            </div>
                            <i class="fas fa-user-tie fs-1 text-info bg-black border rounded-full secondary-bg p-3 "></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2" id="fees">Product</h3>                                
                                
                            </div>
                            <i class="fa fa-product-hunt fs-1 text-info bg-black border rounded-full secondary-bg p-3 "></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div> 




  
    

       
<script src="../js/vue.3.js"></script>
<script src="../js/axios.js"></script>
 <script src="../js/script.js"></script>

</body>
</html>
    
