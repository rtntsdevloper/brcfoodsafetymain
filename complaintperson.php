  
  <?php
    include 'connection.php';

    $product = $_POST['product'];
    $sno = $_POST['srno'];
    $code = $_POST['code'];
    $behalf = $_POST['behalf'];
    $content = $_POST['content'];
   

    $qsp = mysqli_query($con, "UPDATE `tblnewcomplaint` SET `person`='$product',`desig`='$code',`behalf`='$behalf',`content`='$content' WHERE id='$sno'");

    if ($qsp) {

        echo "<script >
               document.location.href='admin.php?id=complaintview&sno=".$sno."';
            </script>";
    }

    ?>