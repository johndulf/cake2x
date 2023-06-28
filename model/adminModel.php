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
function updateStatusReserve(){
    global $con;
    $status = $_POST['status'];
    $reservedid = $_POST['id'];
    $query = $con->prepare('call sp_updateStatusReserve(?,?)');
    $query->bind_param('ii',  $reservedid,$status);
    if($query->execute()){
        echo 1;
    }
    else{
        echo json_encode(mysqli_error($con));
    }
}
function getAllUser(){
    global $con;
    $id = $_POST['userid'];
    $query = $con->prepare('call sp_getAllUser(?)');
    $query->bind_param('i', $id);
    $query->execute();
    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    echo json_encode($data);
}
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
function deleteReservation()
{
    global $con;
    $reserved_id = $_POST['reserved_id'];
    $query = $con->prepare("DELETE FROM tbl_reserved WHERE reserved_id = ?");
    $query->bind_param('i',$reserved_id);
    if ($query->execute()) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Failed to delete reservation'));
    }
    $query->close();
    $con->close();
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