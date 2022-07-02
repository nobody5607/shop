<?php
//conection database
include "./config.php";

$status = $_GET['status'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
if($status != 'delete'){
    if($_POST){
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
        $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
        $image = isset($_POST['image']) ? $_POST['image'] : '';
        $qty = isset($_POST['qty']) ? $_POST['qty'] : '';
        $price = isset($_POST['price']) ? $_POST['price'] : '';
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    }else{
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    }
}
if ($status == 'find-all') {
    //insert
    $sql = "Select * From carts Where user_id='{$user_id}'";
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
else if ($status == 'add') {

    //check cart
    $sql_check="Select * From carts Where user_id='{$user_id}' And product_id='{$product_id}'";
    $result_check = $conn->query($sql_check);
    $create_date = date('Y-m-d h:i:s');

    //found cart and update qty
    if ($result_check->num_rows > 0) {
       
        $result_check = $result_check->fetch_assoc();
        $qty_update = $result_check['qty'] + 1;
        $conn->query("Update carts set qty='{$qty_update}' Where id = {$result_check['id']}");
        //duplicate information
    }else{
        //add cart
        $conn->query("Insert Into carts(product_id,product_name,qty,price,create_date,user_id,image) Values('{$product_id}',
                         '{$product_name}','{$qty}','{$price}','{$create_date}','{$user_id}','{$image}') ");
                          

    }
    //get count cart
    $count = getCountCart($conn, $user_id);
    echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลสำเร็จ', 'data'=>$count]);

}else if ($status == 'get-count') {
    $count = getCountCart($conn, $user_id);
    echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลสำเร็จ', 'data' => $count]);
}
else if ($status == 'update-cart') {
        if($qty > 0){
            $sql = "Update carts set qty='{$qty}' Where id='{$id}'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['status' => 'success', 'message' => 'อัปเดทตะกร้าสินค้าสำเร็จ']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $conn->error]);
            }
        }else{
            echo deleteCart($conn, $id);
        }
}
else if($status == 'delete'){
    echo deleteCart($conn, $id);
}

function getShipping($conn, $user_id){

}
function deleteCart($conn, $id){
        $sql = "Delete From carts Where id = '{$id}' ";
    if ($conn->query($sql) === TRUE) {
        return json_encode(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        return json_encode(['status' => 'error', 'message' => $conn->error]);
    }
}

function getCountCart($conn, $user_id){
    $sql2 = "Select count(*) as count_cart From carts Where user_id = {$user_id}";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {
        return $result2->fetch_assoc();
    }
    return 0;
}

?>