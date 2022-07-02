<?php
//conection database
include "./config.php";

$status = isset($_GET['status']) ? $_GET['status'] : '';


switch ($status){
    case 'get-order-all':
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $output = [];
        $sql = "SELECT o.*,(SELECT name FROM user WHERE id = o.user_id) as user_name FROM orders as o ORDER BY  o.id DESC";
        $result = $conn->query($sql);
        while($order = $result->fetch_assoc()) {
            if($order['payment_status'] == 1){
                $order['payment_status']='รอดำเนินการ';
            }else if($order['payment_status'] == 2){
                $order['payment_status']='ชำระเงินแล้ว';
            }else{
                $order['payment_status']='กรุณาชำระเงิน';
            }

            if($order['delivery_status'] == 1){
                $order['delivery_status']= "กำลังจัดส่ง";
            }else if($order['delivery_status'] == 2){
                $order['delivery_status']= "จัดส่งสำเร็จ";
            }else if($order['delivery_status'] == 3){
                $order['delivery_status']= "ยกเลิก";
            }else{
                $order['delivery_status']= "รอดำเนินการ
            ";
            }
            $order_detail=[];
            $result2 = $conn->query("SELECT * FROM order_details WHERE order_id = '{$order['id']}' ");
            while ($row = $result2->fetch_assoc()) {
                $order_detail[] = $row;
            }
            $order['order_detail'] = $order_detail;
            $output[] = $order;
        }
        echo json_encode(['status' => 'success', 'message' => '', 'data' => $output]);
        break;
    case 'get-order-all-by-user':
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $output = [];
        $sql = "SELECT * FROM orders WHERE user_id='{$user_id}' ORDER BY  id DESC";
        $result = $conn->query($sql);
        while($order = $result->fetch_assoc()) {
            if($order['payment_status'] == 1){
                $order['payment_status']='รอดำเนินการ';
            }else if($order['payment_status'] == 2){
                $order['payment_status']='ชำระเงินแล้ว';
            }else{
                $order['payment_status']='กรุณาชำระเงิน';
            }

            if($order['delivery_status'] == 1){
                $order['delivery_status']= "กำลังจัดส่ง";
            }else if($order['delivery_status'] == 2){
                $order['delivery_status']= "จัดส่งสำเร็จ";
            }else if($order['delivery_status'] == 3){
                $order['delivery_status']= "ยกเลิก";
            }else{
                $order['delivery_status']= "รอดำเนินการ
            ";
            }
            $order_detail=[];
            $result2 = $conn->query("SELECT * FROM order_details WHERE order_id = '{$order['id']}' ");
            while ($row = $result2->fetch_assoc()) {
                $order_detail[] = $row;
            }
            $order['order_detail'] = $order_detail;
            $output[] = $order;
        }
        echo json_encode(['status' => 'success', 'message' => '', 'data' => $output]);
        break;
    case 'add':
        //get sum cart
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $shipping_address = isset($_POST['shipping_address']) ? $_POST['shipping_address'] : '';
        $total_price = 0;
        $sql = "SELECT * FROM carts WHERE user_id='{$user_id}'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $total_price += $row['price'] * $row['qty'];
            $sql_order_detail = "INSERT INTO order_details(order_id, product_id, product_name,qty,price,product_image) 
                VALUES('{$order_id}', '{$row['product_id']}', '{$row['product_name']}' , '{$row['qty']}', '{$row['price']}','{$row['image']}'); ";
            $conn->query($sql_order_detail);
        }
        //insert orders
        $create_date = date('Y-m-d h:i:s');//date now
        $result1 = $conn->query("
            INSERT INTO orders(id,total_price,user_id,create_date,shipping_address) VALUES ('{$order_id}','{$total_price}','{$user_id}','{$create_date}','{$shipping_address}')
        ");

        if ($result1) {
            $conn->query("DELETE FROM carts WHERE user_id='{$user_id}'");
            echo json_encode(['status' => 'success', 'message' => 'สั่งซื้อสินค้าสำเร็จ ขอบคุณที่ใช้บริการค่ะ']);
        } else {
            echo json_encode(['status' => 'error', 'message' =>'เกิดข้อผิดพลาดในการสั่งซื้อสินค้า']);
        }
        break;
    case 'get-order-by-id':
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
        $backend = isset($_GET['backend']) ? $_GET['backend'] : '';
        $output = [];
        $sql = "SELECT * FROM orders WHERE id='{$order_id}' ";
        $result = $conn->query($sql);
        $order = $result->fetch_assoc();

        if($backend == ''){
            if($order['payment_status'] == 1){
                $order['payment_status']='รอดำเนินการ';
            }else if($order['payment_status'] == 2){
                $order['payment_status']='ชำระเงินแล้ว';
            }else{
                $order['payment_status']='กรุณาชำระเงิน';
            }

            if($order['delivery_status'] == 1){
                $order['delivery_status']= "กำลังจัดส่ง";
            }else if($order['delivery_status'] == 2){
                $order['delivery_status']= "จัดส่งสำเร็จ";
            }else if($order['delivery_status'] == 3){
                $order['delivery_status']= "ยกเลิก";
            }else{
                $order['delivery_status']= "รอดำเนินการ";
            }
        }
        if($order){
            $order_detail=[];
            $result2 = $conn->query("SELECT * FROM order_details WHERE order_id = '{$order['id']}' ");
            while ($row = $result2->fetch_assoc()) {
                $order_detail[] = $row;
            }
            $order['order_detail'] = $order_detail;
        }


        echo json_encode(['status' => 'success', 'message' => '', 'data' => $order]);
        break;

    case 'upload-slip':
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $image_slip = isset($_POST['image_slip']) ? $_POST['image_slip'] : '';
        $sql = "UPDATE orders SET image_slip = '{$image_slip}', payment_status='1' WHERE user_id='{$user_id}' AND id='{$order_id}'";
        if ($conn->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'อัปโหลดหลักฐานการชำระเงินสำเร็จ']);
        } else {
            echo json_encode(['status' => 'error', 'message' =>'เกิดข้อผิดพลาดในการสั่งซื้อสินค้า']);
        }
        break;
    case 'update-order-status':
        $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
        $delivery_status = isset($_POST['delivery_status']) ? $_POST['delivery_status'] : '';
        $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';

        $sql = "UPDATE orders SET delivery_status = '{$delivery_status}', payment_status='{$payment_status}' WHERE id='{$order_id}'";
        if ($conn->query($sql)) {
            echo json_encode(['status' => 'success', 'message' => 'อัปเดทสถานะคำสั่งซื้อสำเร็จ']);
        } else {
            echo json_encode(['status' => 'error', 'message' =>'เกิดข้อผิดพลาดในการสั่งซื้อสินค้า']);
        }
        break;
    default:
        break;
}



?>