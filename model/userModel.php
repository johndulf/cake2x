<?php 

include "../includes/config.php"; 

session_start();

$method = $_POST['method'];

if(function_exists($method)){ //fnSave
    call_user_func($method);
}
else{
    echo "Function not exists";
}
function fnReserve(){
    global $con;
    $product_id= $_POST['product_id'];
    $user_id= $_SESSION['userid'];
    $size= $_POST['sizes'];
    $price= $_POST['price'];
    $quantity= $_POST['quantity'];
    $total = $_POST['total'];
    $status= $_POST['status'];
    $reserved_id= $_POST['reserved_id'];

    $query= $con->prepare('call sp_saveUpdateReserved(?,?,?,?,?,?,?,?)');
    $query->bind_param('iisiiiii',$product_id,$user_id,$size,$price,$quantity,$total,$status,$reserved_id);

    if($query->execute()){
        echo 1;
    }
    else{
        echo json_encode(mysqli_error($con));
    }

}
function fnCheckStatus(){
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        echo 1;
    }else{
        echo 2;
    }
}
function fnSave(){
    global $con;
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
     $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $userid = $_POST['userid'];

    $query = $con->prepare('call sp_save(?,?,?,?,?,?,?)');
    $query->bind_param('issssss',$userid,$fullname,$username,$password,$address,$mobile,$email);
    
    if($query->execute()){
        echo 1;
    }
    else{
        echo json_encode(mysqli_error($con));
    }

}

function fnGetUsers(){
    global $con;
    $userid = $_POST['userid'];
    if($userid == 0){
        $query = $con->prepare("SELECT * FROM tbl_users");
    }
    else{
        $query = $con->prepare("SELECT * FROM tbl_users where userid = $userid");
    }
    
    $query->execute();
    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_array()){
        $data[] = $row;
    }

    echo json_encode($data);

}

 function DeleteUser(){
        global $con;
        $userid = $_POST['userid'];
        $query = $con->prepare("DELETE FROM tbl_users where userid = ?");
        $query->bind_param('i',$userid);
        $query->execute();
        $query->close();
        $con->close();
    }

function fnLogin(){
    global $con;
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = $con->prepare("call sp_login(?,?)");
    $query->bind_param('ss',$username,$password);
    $query->execute();
    $result = $query->get_result();
    $ret = '';
    while($row = $result->fetch_array()){
        
        if($row['ret'] == 1){
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['mobile'] = $row['mobile'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['role'] = $row['user_role'];
            $ret = ['ret'=>$row['ret'],'user_role'=> (int)$row['user_role']];
        }else{
            $ret = ['ret'=>$row['ret']];
        }

    }

    echo json_encode($ret);
    // echo json_encode($result->fetch_array());

}

function fnUnlockAccount(){
    global $con;
    $userid = $_POST['userid'];
    $query = $con->prepare("UPDATE tbl_users SET counterlock = 0 where userid = $userid");
    $query->execute();
    echo 1;

}


?>