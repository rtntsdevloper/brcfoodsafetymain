

<?php
$vst = $_GET['pid'];

$vstr = mysqli_query($con,"SELECT * FROM `tblfryoil` WHERE reason = '$vst'");
$vstr1 = mysqli_fetch_array($vstr);

$vid = $vstr1['id'];

?>


<script language="javascript">
	jQuery(document).ready(function($) {
		// Store the window width
		var windowWidth = $(window).width();
		// Resize Event
		$(window).resize(function() {

			// Check window width has actually changed and it's not just iOS triggering a resize event on scroll
			if ($(window).width() != windowWidth) {

				// Update the window width for next time
				windowWidth = $(window).width();

				// Do stuff here

			}

			// Otherwise do nothing

		});

	});
</script>
<style>
	.kbw-signature {
		width: 400px;
		height: 200px;
	}

	#signature canvas {
		width: 100% !important;
		height: auto;
	}

	.kbw-signature1 {
		width: 400px;
		height: 200px;
	}

	#signature1 canvas {
		width: 100% !important;
		height: auto;
	}

	.container {
		margin-left: 420px;

	}
</style>


	
	<script src="dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
	<script src="dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
	<script src="dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
	<script src="dist-assets/js/scripts/script.min.js"></script>
	<script src="dist-assets/js/scripts/sidebar.large.script.min.js"></script>
	<script src="dist-assets/js/plugins/echarts.min.js"></script>
	<script src="dist-assets/js/scripts/echart.options.min.js"></script>
	<script src="dist-assets/js/plugins/datatables.min.js"></script>
	<script src="dist-assets/js/scripts/form.validation.script.min.js"></script>
	<script src="dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
	<script src="dist-assets/js/plugins/sweetalert2.min.js"></script>

	
	

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>


	


		<div class="main-content-wrap sidenav-open d-flex flex-column">
			<div class="container-fluid ">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body p-5">
							<div class="row mt-3">
								<div class="col-md-6">
									<h3 style="color:#FF0000"> Signature</h3>
									<form id="uploadForm3" method="post" action="">
										<input type="hidden" name="sno" value="<?php echo $vid; ?>">

										<div id="res" style="color:red; font-size:20px"></div>
										<br />
										<div id="signature"></div>
										<br />
										<br>
										<button id="clear" class="btn btn-warning">Clear Signature</button>
										<button class="btn btn-success" id="Submit" type="submit" style="margin-left:20px">Signature & Verify</button>

										<textarea id="sigpad" name="signature_image" style="display: none"></textarea>

									</form>


								</div>


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize signature pad
        var signature = $('#signature').signature({
            syncField: '#sigpad',
            syncFormat: 'PNG'
        });

        // Clear signature handler
        $('#clear').click(function(e) {
            e.preventDefault();
            signature.signature('clear');
            $("#sigpad").val('');
        });

        // Form submission handler
        $("#uploadForm3").on('submit', function(e) {

            e.preventDefault();
            
            // Validate signature exists
            if (!$("#sigpad").val()) {
                $("#res").html('<span style="color:red;">Please provide a signature first.</span>');
                return false;
            }

            $.ajax({
                url: "precord/fryoilsign1",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (!data) {
                        $("#res").html('<span style="color:red;">Signature not verified.</span>');
                    } else {
                        window.location.href = "admin.php?id=fryeroil";
                    }
                },
                error: function(xhr, status, error) {
                    $("#res").html('<span style="color:red;">Error: ' + error + '</span>');
                }
            });
        });
    });
</script>