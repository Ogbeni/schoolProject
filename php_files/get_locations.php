<?php
    require('./DbUtils.php');
    $db = new DbUtils();
    $conn = $db->getConn();
    if(isset($_POST['lat'])){
        $lat = mysqli_real_escape_string($conn, $_POST['lat']);
        $lng = mysqli_real_escape_string($conn, $_POST['lng']);
        $qry = "SELECT * FROM hospitals
         where acos( sin(radians(hosp_lat))*sin(radians($lat)) + cos(radians(hosp_lat))*cos(radians($lat))*cos(radians(hosp_lng) - radians($lng)) )*6371 <=800";
        $result= mysqli_query($conn, $qry);
        $result_arr = array();
        // echo mysqli_num_rows($result);
        while($row = mysqli_fetch_row($result)){
            $result_arr[] =  $row;
        }
        //echo json_encode( var_dump($result) );
        if($result){
            echo json_encode( $result_arr );
        }else{
            echo mysqli_error($conn);
        }
    }else{
       echo mysqli_error($conn);
    }
    
  ?>
