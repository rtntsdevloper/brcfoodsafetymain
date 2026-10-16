<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <style>
        table {
            height: 500px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <!-- <img src="image/logo-icon.png" alt="homepage" class="light-logo d-flex justify-content-start" width="100"
                style="margin-left:20px;" /> -->
            <img src="../images/rtnts.png" alt="homepage" class="light-logo" width="150" style="margin-left:300px;" />
        </div> 
    </div>
    <div class="row">
        <h1 align="center">Test Report</h1><BR><BR><BR><BR>
    </div>
    <?php
    $ide = $_REQUEST['ide'];

    

    // $connection = mysqli_connect('localhost', 'root', '', 'rtnts');
    include '../connection.php';
    // $query = "SELECT * from `attempt`";
    $query = "SELECT * from `attempt` where ide='$ide'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    ?>
    <table border="1px" width="100%" height="100%" class="table-bordered">
        <tr>
            <td class="aa">Company Name</td>
            <td class="bb"><?php echo $row['company_name']; ?></td>
        </tr>
        <tr>
            <td class="aa">Unit No</td>
            <td class="bb"><?php echo $row['unit_no']; ?></td>
        </tr>
        <tr>
            <td class="aa">Location</td>
            <td class="bb"><?php echo $row['location']; ?></td>
        </tr>
       
        <tr>
            <td class="aa">Contract No</td>
            <td class="bb"><?php echo $row['contractno'];?></td>
        </tr>
    </table>
          



        <?php 
    
    // Close the database connection
    mysqli_close($con);
    ?>
     <?php
    
    $ide=$_REQUEST['ide'];
    // $connection = mysqli_connect('localhost', 'root', '', 'rtnts');
    include '../connection.php';
   
    $query1 = "SELECT * from `tab_que`";
    $query2 = "SELECT * from `response` where ide='$ide'";
    $result1 = mysqli_query($con, $query1);
    $result2 = mysqli_query($con, $query2);

   while(($row1 = mysqli_fetch_array($result1)) && ( $row2 = mysqli_fetch_array($result2))) {
    
    ?>
    <br>
    <table border="1px" width="100%" height="100%" class="table-bordered">
        <tr>
       
            <td class="a">Question <?php echo $row1['sr_no'];?></td>
            <td class="b" ><?php echo $row1['question']; 
           
            ?></td>
        </tr>
        <?php
        if($row2['answer']){
        ?>
        <tr>
            <td class="a">Answer</td>
            <td class="b" ><?php
            
            if($row2['answer']=='No'){
              echo  '<p style="color:red;">';
            echo $row2['answer'];
            echo '</p>';
            }
            elseif($row2['answer']=='NA'){
                echo  '<p style="color:green;">';
                echo $row2['answer'];
                echo '</p>';
            }
           else{
            echo $row2['answer'];
           }
            ?></td>
        </tr><?php } ?>
        <?php
            if($row2['comment']){
            ?>
        <tr>
           
            <td class="a">Comment </td>
            <td class="b" ><?php echo $row2['comment']; 
           
            ?></td> </tr>
           <?php } ?>
       
           <?php
            if($row2['fur_com']){
            ?>
        <tr>
           
            <td class="a">Comment </td>
            <td class="b" ><?php echo $row2['fur_com']; 
           
            ?></td> </tr>
           <?php } ?>
       
       
           <?php
            if($row2['pic']){
            ?>
           <tr>
            
            <td class="a">Document </td>
            <td class="b" ><?php  
                if( $row2['pic']){

                echo '<img src="../auditpic/'. $row2['pic'] .'">'; 
                }
                else{
                  echo '';
                }
                ?></td>
        </tr>
       <?php } ?>
    </table>
    <?php
             }
       ?>
</body>

</html>