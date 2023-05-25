<?php 

include "../includes/config.php"; 

$method = $_POST['method'];

if(function_exists($method)){ //fnSave
    call_user_func($method);
}
else{
    echo "Function not exists";
}

// function fnSaveCustomize(){
//     global $con;
//     $suggestion = $_POST['suggestion'];
//     $message = $_POST['message'];
//     $flavor = $_POST['flavors'];
//     $size = $_POST['sizes'];
//     $mobile = $_POST['mobile'];
//     $quantity = $_POST['quantity'];
//     $date = $_POST['date'];
//     $status = $_POST['status'];
//     $userid = $_POST['userid'];
//     $reserveid = $_POST['reserveid'];

//     $filename = $_FILES['productimage']['name'];
//     $folder = '../uploads/';
//     $destination = $folder . $filename;
//     move_uploaded_file($_FILES['productimage']['tmp_name'],$destination);

//     $query = $con->prepare('call sp_saveCustomize(?,?,?,?,?,?,?,?,?,?)');
//     $query->bind_param('ssssiisiii',$suggestion,$message,$flavor,$size,$mobile,$date,$filename,$status,$userid,$reserveid);
    
//     if($query->execute()){
//         echo 1;
//     }
//     else{
//         echo json_encode(mysqli_error($con));
//     }

// }

function fnSaveCustomize(){
    global $con;
      $suggestion = $_POST['suggestion'];
    $message = $_POST['message'];
    $user_id= $_SESSION['userid'];
     $flavor = $_POST['flavors'];
    $size= $_POST['sizes'];
    $quantity= $_POST['quantity'];
    $mobile = $_POST['mobile'];
    $total = $_POST['total']
    $status= $_POST['status'];
    $reserved_id= $_POST['reserved_id'];

    $query= $con->prepare('call sp_saveUpdateCustomize(?,?,?,?,?,?,?,?,?)');
    $query->bind_param('ssisiiiii',$suggestion,$message,$userid,$size,$quantity,$mobile,$total,$status,$reserved_id);

    if($query->execute()){
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