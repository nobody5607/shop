<?php
    //conection database
    include "./config.php";
    $username = $_POST['username'];
    $password = $_POST['password'];

    //query user by username
    $sql = "Select * From user Where username = '{$username}' ";

    $result = $conn->query($sql);
    $result = $result->fetch_assoc();

    //return result
    $errorStatus = ['status'=>'error', 'message'=>'กรุณาตรวจสอบชื่อผู้ใช้งานหรือรหัสผ่าน'];
    if($result){
        if($result['password'] === $password){
            //login success
            echo json_encode(['status'=>'success', 'data'=>$result]);
        }else{
            //login fail
            echo json_encode($errorStatus);
        }
    }else{
        //login fail
        echo json_encode($errorStatus);
    }



?>