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

function fnSaveSeller(){
    global $con;
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
     $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $sellerid = $_POST['sellerid'];

    $query = $con->prepare('call sp_saveSeller(?,?,?,?,?,?,?)');
    $query->bind_param('issssis',$sellerid,$fullname,$username,$password,$address,$mobile,$email);
    
    if($query->execute()){
        echo 1;
    }
    else{
        echo json_encode(mysqli_error($con));
    }

}

function fnGetSellers(){
    global $con;
    $sellerid = $_POST['sellerid'];
    if($sellerid == 0){
        $query = $con->prepare("SELECT * FROM tbl_sellers");
    }
    else{
        $query = $con->prepare("SELECT * FROM tbl_sellers where sellerid = $sellerid");
    }
    
    $query->execute();
    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_array()){
        $data[] = $row;
    }

    echo json_encode($data);

}

 function DeleteSeller(){
        global $con;
        $sellerid = $_POST['sellerid'];
        $query = $con->prepare("DELETE FROM tbl_sellers where sellerid = ?");
        $query->bind_param('i',$sellerid);
        $query->execute();
        $query->close();
        $con->close();
    }

function fnLogin(){
    global $con;
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = $con->prepare("call sp_loginSeller(?,?)");
    $query->bind_param('ss',$username,$password);
    $query->execute();
    $result = $query->get_result();
    $ret = '';
    while($row = $result->fetch_array()){
        
        if($row['ret'] == 1){
            $_SESSION['sellerid'] = $row['sellerid'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role'] = $row['user_role'];
        }
        $ret = $row['ret'];
    }

    echo $ret;

}

function fnUnlockAccount(){
    global $con;
    $sellerid = $_POST['sellerid'];
    $query = $con->prepare("UPDATE tbl_sellers SET counterlock = 0 where sellerid = $sellerid");
    $query->execute();
    echo 1;

}


?>