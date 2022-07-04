<?php

    require_once "delivery.php";

    try {
        $api = new Delivery();
        echo $api->run();
    } catch (Exception $e) {
        echo json_encode( Array('error' => $e->getMessage()));
    }

?>