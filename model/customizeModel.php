<?php 
session_start();
include "../includes/config.php"; 

$method = $_POST['method'];

if(function_exists($method)){ //fnSave
    call_user_func($method);
}
else{
    echo "Function not exists";
}

function fnSaveCustomize(){
    global $con;
    $suggestion = $_POST['suggestion'];
    $message = $_POST['message'];
    $flavor = $_POST['flavor'];
    $size = $_POST['size'];
    $quantity =(int) $_POST['quantity'];
    $date = $_POST['date'];
    $userid =  $_SESSION['userid'];
    $reserveid = (int)$_POST['reserveid'];
    $price=(int)$_POST['price'];
    $total = $quantity * $price;
    $filename = $_FILES['productimage']['name'];
    $query = $con->prepare('call sp_saveCustomize(?,?,?,?,?,?,?,?,?,?,?)');
    $query->bind_param('iissssiiiss',$reserveid ,$userid,$suggestion,$message,$flavor,$size,$quantity,$price,$total,$filename,$date);
    
    if($query->execute()){
        $folder = '../uploads/';
        $destination = $folder . $filename;
        move_uploaded_file($_FILES['productimage']['tmp_name'],$destination);
        echo 1;
    }
    else{
        echo json_encode(mysqli_error($con));
    }

}

function fnGetCustomize(){
    global $con;
    $reserveid = $_POST['reserveid'];
    $query = $con->prepare("call sp_getCustomize(?)");
    $query->bind_param('i',$reserveid);
    $query->execute();
    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_array()){
        $data[] = $row;
    }

    echo json_encode($data);

}

// function updateStatusCustomize(){
//     global $con;
//     $status = $_POST['status'];
//     $reservedid = $_POST['id'];
//     $query = $con->prepare('call sp_updateStatusReserve(?,?)');
//     $query->bind_param('ii',  $reservedid,$status);
//     if($query->execute()){
//         echo 1;
//     }
//     else{
//         echo json_encode(mysqli_error($con));
//     }
// }
function getReserveList(){
    global $con;
    $id = $_POST['id'];
    $query = $con->prepare('call sp_getReserveList(?)');
    $query->bind_param('i',$id);
    $query->execute();

    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    echo json_encode($data);

    
}



// function fnGetProducts(){
//     global $con;
//     $productid = $_POST['productid'];
//     $query = $con->prepare("call sp_getProducts(?)");
//     $query->bind_param('i',$productid);
//     $query->execute();
//     $result = $query->get_result();
//     $data = array();
//     while($row = $result->fetch_array()){
//         $data[] = $row;
//     }

//     echo json_encode($data); 

// }
    function DeleteCustomize(){
        global $con;
        $reserveid = $_POST['reserveid'];
        $query = $con->prepare("DELETE FROM tbl_customize where reserveid = ?");
        $query->bind_param('i',$reserveid);
        $query->execute();
        $query->close();
        $con->close();
    }

?>