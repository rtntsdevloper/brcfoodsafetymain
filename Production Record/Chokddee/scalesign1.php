<?php
// Securely get and sanitize GET parameters to prevent XSS attacks.
$vst = htmlspecialchars($_GET['dtv'] ?? '', ENT_QUOTES, 'UTF-8');
$tid = htmlspecialchars($_GET['tid'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verification Signature</title>

	<link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">

	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

	<style>
		/* --- Original and Desktop Styles --- */

		/* Consolidate signature pad styles */
		body{
			overflow :hidden
		}
		.kbw-signature {
			width: 100%;
			/* Make it responsive */
			max-width: 400px;
			/* Set a max-width for larger screens */
			height: 200px;
			border: 1px solid #ced4da;
			/* Add a light border */
			border-radius: .25rem;
		}

		#signature canvas {
			width: 100% !important;
			height: auto;
		}

		/* Utility classes to replace inline styles */
		.form-actions {
			display: flex;
			/* Use flexbox for easy alignment */
			flex-wrap: wrap;
			/* Allow buttons to wrap if needed */
			align-items: center;
			margin-top: 15px;
		}

		.form-actions .btn {
			margin-right: 10px;
			margin-bottom: 10px;
			/* Add bottom margin for wrapping cases */
		}

		.status-message {
			font-size: 1rem;
			font-weight: bold;
			margin-bottom: 15px;
		}

		.status-message.error {
			color: #dc3545;
			/* Bootstrap danger color */
		}


		/* --- Mobile Responsive Styles --- */
		/* Apply these styles on screens 576px wide or smaller */
		@media (max-width: 576px) {
			.form-actions {
				/* Stack the buttons vertically on small screens */
				flex-direction: column;
				align-items: stretch;
				/* Make buttons fill the width */
			}

			.form-actions .btn {
				width: 100%;
				/* Make buttons full-width for easy tapping */
				margin-right: 0;
				/* Remove right margin in vertical layout */

				/* Ensure all but the last button have space below them */
			}

			.form-actions .btn:not(:last-child) {
				margin-bottom: 10px;
			}
		}
	</style>
</head>

<body>

	<div class="main-content">
		<div class="container mt-4">


			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<h3>Verify Signature</h3>

							<form id="signatureForm" method="post">
								<input type="hidden" name="sno" value="<?php echo $vst; ?>">
								<input type="hidden" name="tid" value="<?php echo $tid; ?>">

								<div id="status" class="status-message"></div>

								<div id="signature"></div>

								<textarea id="signatureData" name="signature_image" style="display: none;"></textarea>

								<div class="form-actions">
									<button type="button" id="clearSignatureBtn" class="btn btn-warning">Clear Signature</button>
									<button type="submit" class="btn btn-success">Signature & Verify</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
	<script src="assets/js/jquery.signature.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

	<script>
		// Use modern document-ready syntax
		$(function() {

			// Initialize the signature pad
			var sig = $('#signature').signature({
				syncField: '#signatureData',
				syncFormat: 'PNG' // Use PNG as it supports transparency
			});

			// Handle the 'Clear' button click
			$('#clearSignatureBtn').on('click', function(e) {
				e.preventDefault();
				sig.signature('clear');
			});


			$('#signatureForm').on('submit', function(e) {
				e.preventDefault(); // Prevent the default form submission



				$.ajax({
					url: "precord/scalesign", // The backend endpoint
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					success: function(data) {
						// Trim whitespace from the response for a more reliable check
						if (data.trim() !== "") {
							// BUG FIX: Correctly construct the redirect URL
							const redirectUrl = `admin.php?id=scale1&dt=<?php echo $vst; ?>&tid=<?php echo $tid; ?>`;
							window.location.href = redirectUrl;
						} else {
							$('#status').addClass('error').text('Signature not verified. Please try again.');
						}
					},
					error: function(xhr, status, error) {
						// Provide more user-friendly error feedback
						$('#status').addClass('error').text('An unexpected error occurred. Please check your connection and try again.');
						console.error("AJAX Error:", status, error); // Log detailed error for debugging
					},
					complete: function() {

					}
				});
			});

		});
	</script>

</body>

</html>