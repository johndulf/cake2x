<?php 

include "../includes/config.php"; 

$method = $_POST['method'];

if(function_exists($method)){ //fnSave
    call_user_func($method);
}
else{
    echo "Function not exists";
}


function fnGetReserve(){
    global $con;
    $reserveid = $_POST['reserveid'];
    $query = $con->prepare("call sp_getReserve(?)");
    $query->bind_param('i',$reserveid);
    $query->execute();
    $result = $query->get_result();
    $data = array();
    while($row = $result->fetch_array()){
        $data[] = $row;
    }

    echo json_encode($data);

}

    function DeleteReserve(){
        global $con;
        $reserveid = $_POST['reserveid'];
        $query = $con->prepare("DELETE FROM tbl_reserved where reserveid = ?");
        $query->bind_param('i',$reserveid);
        $query->execute();
        $query->close();
        $con->close();
    }

?>