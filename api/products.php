<?php
//conection database
include "./config.php";

$status = $_GET['status'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
if ($status != 'delete') {
    if ($_POST) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $stock = (int)$_POST['stock'];
        $image = $_POST['image'];
    }
}

if ($status == 'find-all') {
    //insert
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $conn->query("set global net_buffer_length=1000000000;");
    $conn->query("set global max_allowed_packet=1000000000000;");

    $sql = "Select * From products";
    if ($search != '') {
        $sql .= " Where name Like '%{$search}%'";
    }
    $result = $conn->query($sql);
    $output = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }
        echo json_encode(['status' => 'success', 'message' => '', 'data' => $output]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'error']);
    }
}else if ($status == 'find-one') {
    //get user by id
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $sql = "Select * From products Where id = {$id}";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => '', 'data'=>$result->fetch_assoc()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบผู้ใช้งาน']);
    }
}
else if ($status == 'create') {
    //insert
    $sql = "Insert Into products(name,price,image,stock) Values('{$name}','{$price}','{$image}',{$stock}) ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else if ($status == 'update') {
    //insert
    $sql = "Update products Set name='{$name}',price='{$price}',image='{$image}',stock='{$stock}' Where id='{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else if ($status == 'delete') {
    $sql = "Delete From products Where id = '{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}


?>