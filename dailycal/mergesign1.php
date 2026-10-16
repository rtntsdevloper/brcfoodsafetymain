
 <?php

    include '../connection.php';
    $sno = $_POST['sno'];

    $date = date("Y-m-d");

    $uniid = "mergesign_" . uniqid() . "_" . $sno;
    $folderPath = "../upl1/";

    $image_parts = explode(";base64,", $_POST['signature_image']);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);

    if ($image_type == "png") {
        $file = $folderPath . $uniid . '.' . $image_type;

        file_put_contents($file, $image_base64);

        $sxg = mysqli_query($con, "SELECT * FROM `tbldailyverify` where id = '$sno'");
        $sxx = mysqli_fetch_array($sxg);
        $sid = $sxx['checkssid'];
        $sixd = explode(",", $sid);
        foreach ($sixd as $sixdd => $sxvalue) {
            $sgh = mysqli_query($con, "UPDATE `dailycheckss` SET `verifysign`='$uniid' WHERE id = '$sxvalue'");
            $sgh1 = mysqli_query($con, "UPDATE `tbldailyverify` SET `sign`='$uniid' , status='Done' WHERE id = '$sno'");
        }
    }
    ?>
