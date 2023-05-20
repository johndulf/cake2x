<?php 

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
    $fullname = $_POST['fullname'];
    $suggestion = $_POST['suggestion'];
    $message = $_POST['message'];
    $flavor = $_POST['flavor'];
    $size = $_POST['size'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $userid = $_POST['userid'];
    $reserveid = $_POST['reserveid'];

    $filename = $_FILES['productimage']['name'];
    $folder = '../uploads/';
    $destination = $folder . $filename;
    move_uploaded_file($_FILES['productimage']['tmp_name'],$destination);

    $query = $con->prepare('call sp_saveCustomize(?,?,?,?,?,?,?,?,?,?,?)');
    $query->bind_param('ssssssiisii',$fullname,$suggestion,$message,$flavor,$size,$address,$mobile,$date,$filename,$userid,$reserveid);
    
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