
	
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>

	<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>

	<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

	<style>
	
@import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

:root
 {
  --line-border-fill: #12192c;
  --line-border-empty:#CCCCCC;
}

* {
  box-sizing: border-box;
}



.progress1-container {
  display: flex;
  justify-content: space-between;
  position: relative;
  margin-bottom: 30px;
  max-width: 100%;
  width: 100%;

}

.progress1-container::before {
  content: '';
  background-color: var(--line-border-empty);
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  height: 4px;
  width: 100%;

}

.progress1 {
  background-color: green;
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  height: 4px;
  width: 0%;
  z-index: 1;
  transition: 0.4s ease;
}



.circle {
  background-color: #fff;
  color: #999;

  height: 30px;
  width: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border:1 px;
  transition: 0.4s ease; z-index: 2;
}

.circle.active {
  border-color: var(--line-border-fill);
}

.btn {
  background-color: var(--line-border-fill);
  color: #0ED2F7;
  border: 0;
  border-radius: 6px;
  cursor: pointer;
  font-family: inherit;
  padding: 16px 60px;
  margin: 5px;
  font-size: 14px;
}

.btn:active {
  transform: scale(0.98);
}

.btn:focus {
  outline: 0;
}

.btn:disabled {
  background-color: var(--line-border-empty);
  cursor: not-allowed;
}
.credit a{
    text-decoration: none;
    color: tomato;
  }

  .credit
   {
      margin-top: 10px;
      text-align: center;
  }

</style>
<?php
include 'connection.php';
?>


    <div class="container" >
      <div class="progress1-container">
        <div class="progress1" id="progress1"></div>
		<?php
		$sql=mysql_query("select * from addtest1");
		while($row=mysql_fetch_array($sql))
		{
		if($row['status']=="1")
     {
		?>
	

        <div class="circle" style="background:#669900;color:#FFFFFF"><?php echo $row['testid'];?></div>
  
		<?php
		}
		else if($row['status']=="0")
       {
		?>
		
        <div class="circle" style="background:#FF0066; color:#FFFFFF"><?php echo $row['testid'];?></div>
       
		<?php
		}
		else 
     {
		?>
		
        <div class="circle" style="background:#CCCCCC; color:#999999"><?php echo $row['testid'];?></div>
       
		<?php
		}
		}
		?>
      </div>
	  
	  <?php
	  if($_GET['sno']==2)
	  {
	  ?>
	  <script>
	
const progress1 = document.getElementById('progress1')
const prev = document.getElementById('prev')
const next = document.getElementById('next')
const circles = document.querySelectorAll('.circle')

let currentActive = 2

    currentActive++

    if(currentActive > circles.length) 
	{
        currentActive = circles.length
    }

    update()


function update()
 {
    circles.forEach((circle, idx) => 
	{
        if(idx < currentActive)
		 {
            
			circle.classList.add('active')
        } 
		else {
            circle.classList.remove('active')
        }
    })

    const actives = document.querySelectorAll('.active')

    progress1.style.width = (actives.length - 1) / (circles.length - 1) * 100 + '%'

    if(currentActive === 1) 
	{
        prev.disabled = true
    } 
	else if(currentActive === circles.length) 
	{
        next.disabled = true
    } 
	else 
	{
        prev.disabled = false
        next.disabled = false
    }
}

</script>
	  <?php
	  }
	  ?>

   
    </div>
    
   
