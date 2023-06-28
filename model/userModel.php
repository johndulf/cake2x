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
function fnSave()
{
    global $con;
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = md5($_POST['password']);
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $userid = $_POST['userid'];

    // Check if the same username exists but with a different password
    $existing_username_count = 0;
    if ($userid == 0) {
        $query = $con->prepare('SELECT COUNT(*) FROM tbl_users WHERE username = ? AND password <> ?');
        $query->bind_param('ss', $username, $password);
        $query->execute();
        $query->bind_result($existing_username_count);
        $query->fetch();
        $query->close();
    }

    // Check if the same password exists but with a different username
    $existing_password_count = 0;
    if ($userid == 0) {
        $query = $con->prepare('SELECT COUNT(*) FROM tbl_users WHERE username <> ? AND password = ?');
        $query->bind_param('ss', $username, $password);
        $query->execute();
        $query->bind_result($existing_password_count);
        $query->fetch();
        $query->close();
    }

    // Check if the same username and password combination exists
    $existing_username_password_count = 0;
    if ($userid == 0) {
        $query = $con->prepare('SELECT COUNT(*) FROM tbl_users WHERE username = ? AND password = ?');
        $query->bind_param('ss', $username, $password);
        $query->execute();
        $query->bind_result($existing_username_password_count);
        $query->fetch();
        $query->close();
    }

    // If the same username but different password exists, same password but different username exists,
   // If the same username but different password exists, return "exists_username"
if ($existing_username_count > 0 && $existing_password_count == 0) {
    echo "exists_username";
    exit;
}

// If the same password but different username exists, return "exists_password"
if ($existing_password_count > 0 && $existing_username_count == 0) {
    echo "exists_password";
    exit;
}

// If the same username and password combination exists, return "exists_username_password"
if ($existing_username_password_count > 0) {
    echo "exists_username_password";
    exit;
}

    // Save/Update the user
    $query = $con->prepare('CALL sp_save(?,?,?,?,?,?,?)');
    $query->bind_param('issssss', $userid, $fullname, $username, $password, $address, $mobile, $email);

    if ($query->execute()) {
        echo 1;
    } else {
        echo "There was an error: " . mysqli_error($con);
    }
}

function fnupdateUser()
{
    global $con;
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    $query = $con->prepare('CALL sp_updateUser(?, ?, ?, ?, ?, ?)');
    $query->bind_param('isssss', $userid, $username, $fullname, $address, $mobile, $email);
    
    if ($query->execute()) {
        echo 1;
    } else {
        echo 2; // Changed to a different value to indicate an error
    }
}    

function fnupdatePassword()
{
    global $con;
    $userid = $_POST['userid'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        echo 3; // Passwords do not match
        return;
    }

    // Retrieve the current password from the database
    $query = $con->prepare('SELECT password FROM tbl_users WHERE userid = ?');
    $query->bind_param('i', $userid);
    $query->execute();
    $result = $query->get_result();

    // Verify if the old password matches the current password
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $currentPassword = $row['password'];
        if (!password_verify($oldPassword, $currentPassword)) {
            echo 4; // Old password is incorrect
            return;
        }
    } else {
        echo 5; // User not found
        return;
    }

    // Hash the new password before updating it in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = $con->prepare('CALL sp_updatePassword(?, ?)');
    $query->bind_param('is', $userid, $hashedPassword);

    if ($query->execute()) {
        echo 1; // Password updated successfully
    } else {
        echo 2; // Error updating the password
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

function deleteUser() {
    global $con;
    $userid = $_POST['userid'];

    // First, retrieve the user information before deleting
    $query = $con->prepare('SELECT * FROM tbl_users WHERE userid = ?');
    $query->bind_param('i', $userid);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $query->close();

    // Get the current date and time
    $deletedDate = date('Y-m-d H:i:s');

    // Next, insert the user into a backup table for record keeping
    $query = $con->prepare('INSERT INTO deleted_users (userid, username, fullname, address, mobile, email, deleted_date) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $query->bind_param('issssss', $user['userid'], $user['username'], $user['fullname'], $user['address'], $user['mobile'], $user['email'], $deletedDate);
    $query->execute();
    $query->close();

    // Finally, delete the user from the main table
    $query = $con->prepare('DELETE FROM tbl_users WHERE userid = ?');
    $query->bind_param('i', $userid);
    $query->execute();
    $query->close();
    $con->close();
}


function restoreUser($userid)
{
    global $con;

    // Retrieve the deleted user information from the backup table
    $query = $con->prepare('SELECT * FROM deleted_users WHERE userid = ?');
    $query->bind_param('i', $userid);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $query->close();

    // Insert the user into the main table
    $query = $con->prepare('INSERT INTO tbl_users (userid, username, fullname, address, mobile, email) VALUES (?, ?, ?, ?, ?, ?)');
    $query->bind_param('isssss', $user['userid'], $user['username'], $user['fullname'], $user['address'], $user['mobile'], $user['email']);
    $query->execute();
    $query->close();

    // Delete the user from the backup table
    $query = $con->prepare('DELETE FROM deleted_users WHERE userid = ?');
    $query->bind_param('i', $userid);
    $query->execute();
    $query->close();
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