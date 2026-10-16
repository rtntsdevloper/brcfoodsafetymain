<?php

include '../connection.php';

$pro = $_POST['pro'];
$prod = $_POST['prod'];
$sid = $_POST['sid'];
$user = $_POST['user'];

$ques = $_POST['ques'];
foreach ($ques as $qkey => $qvalue) {
    $quesid = $_POST['quesid'][$qkey];

    if ($sid == '3') {
        if (isset($_POST['ans1'.$qkey])) {
            $ans1 = $_POST['ans1'.$qkey];
        } else {
            $ans1 = '';
        }

        if (isset($_POST['ans2'.$qkey])) {
            $ans2 = $_POST['ans2'.$qkey];
        } else {
            $ans2 = '';
        }


        if (isset($_POST['ans3'.$qkey])) {
            $ans3 = $_POST['ans3'.$qkey];
        } else {
            $ans3 = '';
        }
    } else {


        if (isset($_POST['ans1'][$qkey])) {
            $ans1 = htmlspecialchars($_POST['ans1'][$qkey]);
        } else {
            $ans1 = '';
        }

        if (isset($_POST['ans2'][$qkey])) {
            $ans2 = htmlspecialchars($_POST['ans2'][$qkey]);
        } else {
            $ans2 = '';
        }


        if (isset($_POST['ans3'][$qkey])) {
            $ans3 = htmlspecialchars($_POST['ans3'][$qkey]);
        } else {
            $ans3 = '';
        }
    }


    $sqxl = "INSERT INTO `save_specification1`(`pxid`, `product`, `ques`, `ans1`, `ans2`, `ans3`, `user`, `qid`) VALUES ('$pro','$prod','$qvalue','$ans1','$ans2','$ans3','$user','$quesid')";
    $sqxl1 = mysqli_query($con, $sqxl);



}


if ($sqxl1) {
?>
    <script>
        window.location.href = "../admin.php?id=productspec2&pro=<?php echo $prod; ?>&sid=<?php echo $sid; ?>";
    </script>

<?php
} else {
    echo "Error: " . $sqxl . "<br>" . mysqli_error($con);
}





?>