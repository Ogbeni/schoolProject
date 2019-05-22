<?php
    $server     = 'localhost';
        $username   = 'root';
        $password   = '';
        $database   = 'teamsafe';

        $dsn        = "mysql:host=$server;dbname=$database";

    try {

        $db = new PDO($dsn, $username, $password);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        // $sth = $db->query("SELECT * FROM locations
        //  where acos( sin(radians(lat))*sin(0.11387190043396286) + cos(radians(lat))*cos(0.11387190043396286)*cos(radians(lng) - 0.058978265567159745) )*6371 <= 200");
        $sth = $db->query("SELECT * FROM locations");
        $locations = $sth->fetchAll();

        echo json_encode( $locations );

    } catch (Exception $e) {
        echo $e->getMessage();
    }
  ?>
