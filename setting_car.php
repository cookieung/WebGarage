        <?php
          session_start();
    $license = $_POST['lc_number'];
    $carBrand = $_POST['car_brand'];
    $idcard_car = $_POST['idcard'];

    if($license && $carBrand && $idcard_car ){
        $connect = mysql_connect("localhost","root","") or die("Couldn't connect to the DB!!");
        mysql_select_db("parking_registration") or die("Couldn't find database");
        $id = mysql_query("SELECT person_id FROM person WHERE id_card_number = '$idcard_car' ");
        $id_result =  mysql_result($id,0);


        $sql2 = "INSERT INTO car (license, brand , person_id) VALUES ('$license', '$carBrand' , '$id_result')";

        $query2 = mysql_query($sql2);

        $slotid = mysql_query("SELECT slot_id FROM parking_slot WHERE status = 'Available'");
        $slot_id = mysql_result($slotid,0);
        $query_update_parking_slot = mysql_query("UPDATE parking_slot SET status = 'Unavailable' WHERE slot_id = '$slot_id'");

        $garageid = mysql_query("SELECT garage_id FROM parking_slot WHERE slot_id = '$slot_id'");
        $garage_id = mysql_result($garageid,0);
        $query_udpate_garage = mysql_query("UPDATE garage SET available_slot = available_slot-1 WHERE garage_id = '$garage_id'");

        $car_id = mysql_result(mysql_query("SELECT car_id FROM car WHERE license = '$license'"),0);
        $sql_insert_parking_card = "INSERT INTO parking_card (slot_id,car_id) VALUE ('$slot_id','$car_id')";
        $query = mysql_query($sql_insert_parking_card);

         header("Location: car_regis.php#Car_regis_content");


    }
 else{
        die("Please enter the lc_number, brand, idcard!");
    }

?>