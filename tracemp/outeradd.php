  <div class="page-header">
  	<div class="page-block">
  		<div class="row align-items-center">
  			<div class="col-md-12">
  				<div class="page-header-title">
  					<h5 class="m-b-10">Dashboard</h5>
  				</div>
  				<ul class="breadcrumb">
  					<li class="breadcrumb-item"><a href="#!">Home / Weight Check - (Add New) </a></li>
  				</ul>

  			</div>
  		</div>
  	</div>
  </div>

  <div class="col-xl-12" style="margin-bottom:20px">

  	<a href="admin.php?id=outerdate"><button type="submit" class="btn  btn-danger" style="float:right;">Go Back</button></a>

  </div>


  <div class="col-sm-12">
  	<div class="card">

  		<div class="card-body">
  			<h4 style="color:#3399FF">Add Outer Packaging Check</h4>






  			<form name="form1" method="post" action="" enctype="multipart/form-data">
  				<div class="row">


  					<div class="col-md-6">
  						<label for="cc-exp" class="control-label mb-1"> Date</label>
  						<div class="input-group">
  							<input type="date" name="date" id="date" class="form-control" required />

  						</div>
  					</div>
  					<div class="col-md-6">
  						<label for="cc-exp" class="control-label mb-1"> Operator Name</label>
  						<input type="text" name="opnm" class="form-control" required>
  					</div>
  					<div class="col-md-6 mt-3">
  						<label for="cc-exp" class="control-label mb-1"> Machine Number</label>
  						<input type="text" name="mcn" class="form-control" required>
  					</div>
  					
  					<div class="col-md-6  mt-3">
  						<div class="form-row">
  							<label for="attendeeSelect" class="h5">Select Product</label>

  							<select id="attendeeSelect" class="form-control">
  								<option value="" disabled selected>Select attendee</option>
  								<?php
									$meetatte = mysqli_query($con, "SELECT * FROM tbllabel where produceleft !='0'");
									foreach ($meetatte as $data) {
									?>
  									<option value="<?php echo $data['recordid']; ?>"
  										data-name="<?php echo $data['pname']; ?>">
  										<?php echo $data['pname'] . " (" . $data['recordid'] . " )" . " (" . $data['produceleft'] . "Packs )"; ?>
  									</option>

  								<?php
									}
									?>


  							</select>
  							<input type="hidden" id="attendeeValues" name="prodbatch">
  							<input type="hidden" id="attendeeDataNames" name="prnm">
  							

  							<div id="selectedAttendeesContainer" class="selected-options mt-2">
  								No attendees selected yet
  							</div>

  						</div>
  					</div>

  				</div>



  		</div>

  		<script>
  			document.addEventListener('DOMContentLoaded', function() {
  				const attendeeSelect = document.getElementById('attendeeSelect');
  				const addAttendeeBtn = document.getElementById('addAttendeeBtn');
  				const selectedAttendeesContainer = document.getElementById('selectedAttendeesContainer');
  				const attendeeValuesInput = document.getElementById('attendeeValues');
  				const attendeeDataNamesInput = document.getElementById('attendeeDataNames');

  				// Arrays to store values separately
  				let attendeeValues = [];
  				let attendeeDataNames = [];

  				attendeeSelect.addEventListener('change', function() {
  					const selectedOption = attendeeSelect.options[attendeeSelect.selectedIndex];

  					if (selectedOption.value && !attendeeValues.includes(selectedOption.value)) {
  						// Add to both arrays
  						attendeeValues.push(selectedOption.value);
  						attendeeDataNames.push(selectedOption.getAttribute('data-name') || '');

  						updateSelectedAttendeesDisplay();
  					}
  				});

  				function updateSelectedAttendeesDisplay() {
  					if (attendeeValues.length === 0) {
  						selectedAttendeesContainer.innerHTML = 'No attendees selected yet';
  						attendeeValuesInput.value = '';
  						attendeeDataNamesInput.value = '';
  						return;
  					}

  					selectedAttendeesContainer.innerHTML = '';

  					// Store as comma-separated strings in hidden inputs
  					attendeeValuesInput.value = attendeeValues.join(',');
  					attendeeDataNamesInput.value = attendeeDataNames.join(';');

  					attendeeValues.forEach((value, index) => {
  						const attendeeElement = document.createElement('div');
  						attendeeElement.className = 'selected-item';

  						// Display both values
  						attendeeElement.innerHTML = `
                                        <span class="attendee-value">${value}</span>
                                        <span class="data-name">${attendeeDataNames[index] ? '(' + attendeeDataNames[index] + ')' : ''}</span>
                                        <span class="remove-btn" data-index="${index}">×</span>
                                    `;

  						selectedAttendeesContainer.appendChild(attendeeElement);
  					});

  					// Add remove functionality
  					document.querySelectorAll('.remove-btn').forEach(btn => {
  						btn.addEventListener('click', function() {
  							const index = parseInt(this.getAttribute('data-index'));
  							attendeeValues.splice(index, 1);
  							attendeeDataNames.splice(index, 1);
  							updateSelectedAttendeesDisplay();
  						});
  					});
  				}

  				// Initialize display
  				updateSelectedAttendeesDisplay();
  			});
  		</script>

  		<div class="col-6">
  			<label for="cc-exp" class="control-label mb-1"></label>
  			<div class="input-group">

  				<button class="btn btn-info" type="submit" name="submit">Save & Next</button>
  			</div>
  		</div>
  		<br />

  	</div>
  	</form>
  </div>
  </div>
  </div>

  <?php
	if (isset($_POST['submit'])) {
		// Basic input sanitization
		$opname = $_POST['opnm'];
		$date = $_POST['date'];
		$machine = $_POST['mcn'];
		$product = $_POST['prnm'];
		$prodbatch = $_POST['prodbatch'];

		// print_r("INSERT INTO `tblouter1`(`name`, `machine`, `date`, `product`,`prodbatch`) VALUES ('$opname','$machine','$date','$product','$prodbatch')");


		$result = mysqli_query($con, "INSERT INTO `tblouter1`(`name`, `machine`, `date`, `product`,`prodbatch`) VALUES ('$opname','$machine','$date','$product','$prodbatch')");


		if ($result) {

			echo '<script>window.location.href = "admin.php?id=outerdate";</script>';
		} else {
			echo "<script>alert('Error adding Delivery Log: " . addslashes(mysqli_error($con)) . "');</script>";
		}

	?>


  <?php
	}
	?>