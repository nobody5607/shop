<?php
//conection database
include "./config.php";

$status = $_GET['status'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
if($status != 'delete'){
    if($_POST){
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : '';
    }
}
if ($status == 'find-all') {
    //insert
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "Select * From user";
    if($search != ''){
        $sql .= " Where name Like '%{$search}%' Or phone Like '%{$search}%'";
    }
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
if ($status == 'find-one') {
    //get user by id
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $sql = "Select * From user Where id = {$id}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => '', 'data'=>$result->fetch_assoc()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบผู้ใช้งาน']);
    }
}
else if ($status == 'create') {
    //insert
    $sql = "Insert Into user Values(null, '{$username}','{$password}', '{$name}', '{$phone}', '{$role}') ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลผู้ใช้งานสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}else if($status == 'update'){
    //insert
    $sql = "Update user Set username='{$username}',password='{$password}',name='{$name}',phone='{$phone}',role='{$role}' Where id='{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลผู้ใช้งานสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}else if($status == 'update-profile'){
    //insert
    $sql = "Update user Set username='{$username}',password='{$password}',name='{$name}',phone='{$phone}' Where id='{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'แก้ไขโปรไฟล์สำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}else if($status == 'update-shipping'){
    //update shipping
    $shipping_name = isset($_POST['shipping_name']) ? $_POST['shipping_name'] : '';
    $shipping_address = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';
    $shipping_phone = isset($_POST['shipping_phone']) ? $_POST['shipping_phone'] : '';
    $sql = "Update user Set shipping_name='{$shipping_name}', 
                shipping_address='{$shipping_address}', shipping_phone='{$shipping_phone}' Where id='{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลผู้ใช้งานสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}
else if($status == 'delete'){
    $sql = "Delete From user Where id = '{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลผู้ใช้งานสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}



?>