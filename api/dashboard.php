<?php
//conection database
include "./config.php";

$status = isset($_GET['status']) ? $_GET['status'] : '';

switch($status){
    case "all-report":
        echo json_encode(['status' => 'success', 'message' => '', 'data' => getReport($conn)]);
        break;
}


function getReport($conn){
    $year = date('Y');
    $select = '';
    for($i=1; $i<=12; $i++){
        $comma = ',';
        if($i==12){
            $comma = "";
        }
        $select .= "
            (SELECT if(sum(total_price) != '' ,sum(total_price), 0) FROM orders WHERE delivery_status=2 AND create_date between '{$year}-{$i}-01' AND '{$year}-{$i}-31') as m{$i}{$comma}
        ";
    }
    $sql= "SELECT
                {$select}
                
    ";
    $result2 = $conn->query($sql);
    if ($result2->num_rows > 0) {
        $data = $result2->fetch_assoc();

       $output=[];
        for($i=1; $i<=12; $i++){
           array_push($output, $data['m'.$i]);
        }
        return $output;
    }
}

?>