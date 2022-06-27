<?php
//conection database
include "./config.php";

$status = $_POST['status'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
if($status != 'delete'){
    $total_price = $_POST['total_price'];
    $user_id = $_POST['user_id'];
    $crate_date = $_POST['crate_date'];
    $delivery_status = $_POST['delivery_status'];
    $payment_status = $_POST['payment_status'];
    $shipping_address = $_POST['shipping_address'];

    $order_detail = json_decode($_POST['order_detail']);
}
if ($status == 'create') {
    //insert
    $sql = "Insert Into orders Values(null, '{$total_price}','{$user_id}','{$crate_date}','{$delivery_status}','{$payment_status}','{$shipping_address}') ";
    if ($conn->query($sql) === TRUE) {

//        foreach($order_detail as $k=>$v){
//            $sql2 = "Insert Into order_details Values(null, '{$v['order_id']}')";
//        }

        echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}else if($status == 'update'){
    //insert
    $sql = "Update orders Set total_price='{$total_price}',user_id='{$user_id}',crate_date='{$crate_date}',delivery_status='{$delivery_status}',payment_status='{$payment_status}',shipping_address='{$shipping_address}' Where id='{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'แก้ไขข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
} else if($status == 'delete'){
    $sql = "Delete From orders Where id = '{$id}' ";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}



?>