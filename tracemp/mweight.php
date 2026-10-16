<?php
// Secure the input by escaping it
$vst = $_GET['eid'];

?>


    
    <!-- Combined CSS -->
    <style>
        .kbw-signature, .kbw-signature1 {
            width: 400px;
            height: 200px;
        }
        #signature canvas, #signature1 canvas {
            width: 100% !important;
            height: auto;
        }
        .container {
            margin-left: 420px;
        }
    </style>
    
    <!-- JS Libraries (combined and moved to head for better loading) -->
    <script src="dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery.signature.min.js"></script>
    <link rel="stylesheet" href="assets/js/jquery.signature.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h3 style="color:#FF0000">Signature</h3>
                                <form id="uploadForm3" method="post" action="">
                                    <input type="hidden" name="sno" value="<?php echo htmlspecialchars($vst); ?>">
                                    
                                    <div id="res" style="color:red; font-size:20px"></div>
                                    <br />
                                    <div id="signature"></div>
                                    <br />
                                    <br>
                                    <button id="clear" class="btn btn-warning" type="button">Clear Signature</button>
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

    <!-- Combined JavaScript -->
    <script>
    $(document).ready(function() {
        // Initialize signature pad
        var signature = $('#signature').signature({
            syncField: '#sigpad',
            syncFormat: 'PNG'
        });
        
        // Clear signature
        $('#clear').click(function(e) {
            e.preventDefault();
            signature.signature('clear');
            $("#sigpad").val('');
        });
        
        // Form submission
        $("#uploadForm3").on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "tracemp/msign",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $("#res").html(data);
                    
                    if (!data) {
                        $("#res").html('<span style="color:red;">Signature not verified.</span>');
                    }else{
						window.location.href = "admin.php?id=weightcheck1&eid=<?php echo $vst;?>";
					}
                },
                error: function() {
                    $("#res").html('<span style="color:red;">Error occurred during submission.</span>');
                }
            });
        });
    });
    </script>
    
    <!-- Additional JS (loaded at the end) -->
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
