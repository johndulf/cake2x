<?php 
    
    include "includes/header.php";
    $app = "<script src='js/app.products.js'></script>";
    $fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
    <style>
        .form-control{
            border:1px solid #000 !important;
        }
    </style>
      <?php if($role == 2): ?>
     <nav>
    
        <ul class="nav-flex-row">
                <h1 class="h1">Heaven's Cake</h1>
             <li class="nav-item">
                <a href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a href="about.php">About</a>
            </li>
            <li class="nav-item">
                <a href="reservation.php">Reservation</a>
            </li>
              <li class="nav-item">
                <a href="schedule.php">Schedule</a>
            </li>

            <li class="nav-item">
                <a href="products.php">Menu</a>
            </li>
            
            <li class="nav-item">
                <?php endif ?>
                    <a href="logout.php"> Welcome <?php echo $fullname; ?></a>
            </li>
        </ul>
    </nav>
     <div id="products-app" style="margin-top:50px;">
