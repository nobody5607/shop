<?php
//conection database
include "./config.php";

$status = $_GET['status'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
if($status != 'delete'){
    $name = isset($_POST['name']) ? $_POST['name'] : '';
}
if ($status == 'find-all') {
    //insert
    $sql = "Select * From categorys ";
    $result = $conn->query($sql);
    $output =[];
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $output[] = $row;
        }
        echo json_encode(['status' => 'success', 'message' => '', 'data'=>$output]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'error']);
    }
}
else if ($status == 'create') {
    //insert
    $sql = "Insert Into categorys(name) Values('{$name}') ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}else if($status == 'update'){
    //insert
    $sql = "Update categorys Set name='{$name}' Where id='{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else if($status == 'delete'){
    $sql = "Delete From categorys Where id = '{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}



?>