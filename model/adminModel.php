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

function fnSave(){
    global $con;
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $first_name = $_POST['first_name'];
     $last_name = $_POST['last_name'];
    $adminid = $_POST['adminid'];

    $query = $con->prepare('call sp_saveAdmin(?,?,?,?,?)');
    $query->bind_param('issss',$adminid,$username,$password,$first_name,$last_name);
    
    if($query->execute()){
        echo 1;
    }
    else{
        echo json_encode(mysqli_error($con));
    }

}

function fnGetAdmins(){
    global $con;
    $adminid = $_POST['adminid'];
    if($adminid == 0){
        $query = $con->prepare("SELECT * FROM tbl_admin");
    }
    else{
        $query = $con->prepare("SELECT * FROM tbl_admin where adminid = $adminid");
    }
    
    $query->execute();
    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_array()){
        $data[] = $row;
    }

    echo json_encode($data);

}

 function DeleteAdmin(){
        global $con;
        $adminid = $_POST['adminid'];
        $query = $con->prepare("DELETE FROM tbl_admin where adminid = ?");
        $query->bind_param('i',$adminid);
        $query->execute();
        $query->close();
        $con->close();
    }

function fnLogin(){
    global $con;
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = $con->prepare("call sp_loginAdmin(?,?)");
    $query->bind_param('ss',$username,$password);
    $query->execute();
    $result = $query->get_result();
    $ret = '';
    while($row = $result->fetch_array()){
        
        if($row['ret'] == 1){
            $_SESSION['adminid'] = $row['adminid'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
        }
        $ret = $row['ret'];
    }

    echo $ret;

}

function fnUnlockAccount(){
    global $con;
    $adminid = $_POST['adminid'];
    $query = $con->prepare("UPDATE tbl_admin SET counterlock = 0 where adminid = $adminid");
    $query->execute();
    echo 1;

}


?>