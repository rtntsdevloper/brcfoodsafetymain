<?php
$sno = $_GET['eid'];


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
<link rel="stylesheet" type="text/css" href="assets/reset.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.signature.js"></script>
<link rel="stylesheet" type="text/css" href="assets/js/jquery.signature.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>




<div class="container-fluid ">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-5">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h3 style="color:#FF0000">Visitor Signature</h3>
                        <form id="uploadForm3" method="post" action="">
                            <input type="hidden" name="sno" value="<?php echo $sno; ?>">

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

    <script type="text/javascript">
        var signature = $('#signature').signature({
            syncField: '#sigpad',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            signature.signature('clear');
            $("#sigpad").val('');
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function(g) {

            $("#uploadForm3").on('submit', (function(g) {
                $("#loading").show();
                g.preventDefault();
                $.ajax({
                    url: "dailysign",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $("#res").html(data);


                        if (data == "") {
                            $("#res").html('<span style="color:red;">Signature not verified.<span>');

                        } else {
                        //    window.open('admin.php?id=dailychecks&tid=<?php echo $tid; ?>','_self');
                        }


                    },
                    error: function() {}
                });
            }));
        });
    </script>