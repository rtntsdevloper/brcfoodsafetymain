<?php
// Your existing database queries remain the same
$sql1 = mysqli_query($con, "select t1.pname, t1.uom, t2.*, t3.*, SUM(t3.box) AS c1,SUM(t3.qty) AS s1, t4.grnno,t4.ans,t4.po,t4.cdate AS dt,t4.user from tblrawmaterial t1, tblrawsupplier t2, tblgrn1 t3 , tblgrnno2 t4 where t1.id=t3.product and t2.supid=t3.supplier and t3.grncode=t4.grnno and t3.id='$_GET[sno]' group by t3.product");
$row2 = mysqli_fetch_array($sql1);

$gddn = $row2['grn'];
// $qr_data = "GRN NO: " . $row2['grn'] . " | Supplier: " . $row2['supname'] . " | Product Name: " . $row2['pname'] . " | PO: " . $row2['po'];
$qr_data=$row2['grn'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GRN - <?php echo $row2['grnno']; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <style>
        /* All styles scoped - won't affect navbar */
        .grn-page {
            max-width: 700px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }

        .grn-actions {
            text-align: right;
            margin-bottom: 15px;
        }

        .grn-actions a,
        .grn-actions button {
            background: #f0f0f0;
            border: 1px solid #ccc;
            padding: 6px 14px;
            margin-left: 8px;
            cursor: pointer;
            font-size: 13px;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            display: inline-block;
        }

        /* Main Heading outside the box */
        .grn-main-heading {
            text-align: center;
            margin-bottom: 15px;
        }

        .grn-main-heading h1 {
            margin: 0;
            font-size: 24px;
            color: #c0392b;
            letter-spacing: 1px;
        }

        .grn-main-heading p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #888;
        }

        /* Bordered container for QR + Data */
        .grn-bordered-box {
            border: 2px solid #333;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Two column layout */
        .grn-split {
            display: flex;
            flex-wrap: wrap;
        }

        .grn-qr-side {
            width: 35%;
            background: #fafafa;
            padding: 20px;
            text-align: center;
            border-right: 1px solid #ddd;
        }

        .grn-data-side {
            width: 65%;
            padding: 15px 20px;
            background: white;
        }

        .grn-qr-title {
            font-size: 12px;
            color: #666;
            margin-top: 8px;
        }

        .grn-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grn-table tr {
            border-bottom: 1px solid #eee;
        }

        .grn-table td {
            padding: 8px 0;
        }

        .grn-table td:first-child {
            width: 100px;
            font-weight: bold;
            color: #555;
        }

        .grn-table td:last-child {
            color: #222;
        }

        /* Inner title removed - now outside */
        .grn-data-side .grn-title {
            display: none;
        }

        .grn-footer {
            text-align: center;
            font-size: 10px;
            color: #aaa;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .grn-qty-badge {
            background: #f0f0f0;
            padding: 2px 10px;
            display: inline-block;
            border-radius: 15px;
        }

        @media print {
            .grn-actions {
                display: none;
            }

            .grn-bordered-box {
                border: 2px solid #000;
            }
        }

        @media (max-width: 550px) {

            .grn-qr-side,
            .grn-data-side {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
</head>

<body>

    <div class="grn-page">
        <div class="grn-actions">
            <a href="admin.php?id=goods">← Back</a>
            <button onclick="printGRN()">🖨️ Print</button>
        </div>
        <!-- Heading outside the box -->
        <div class="grn-main-heading">
            <h1>GOODS RECEIPT NOTE</h1>
            <p>#<?php echo $row2['grnno']; ?></p>
        </div>

        <div id="printArea" class="mt-5">

            <!-- Bordered container -->
            <div class="grn-bordered-box">
                <div class="grn-split">
                    <!-- Left side: QR Code -->
                    <div class="grn-qr-side" style="padding: 40px 30px;">
                        <div id="qrcode"></div>
                        <br>
                        <div class="grn-qr-title mt-3">Scan to verify GRN</div>
                    </div>

                    <!-- Right side: Data -->
                    <div class="grn-data-side">
                        <table class="grn-table">
                            <tr>
                                <td>GRN</td>
                                <td><?php echo $row2['grn']; ?></td>
                            </tr>
                            <tr>
                                <td>Supplier</td>
                                <td><?php echo $row2['supname']; ?></td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td><?php echo $row2['pname']; ?></td>
                            </tr>
                            <tr>
                                <td>PO Number</td>
                                <td><?php echo $row2['po']; ?></td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td><?php echo date('d-m-Y', strtotime($row2['dt'])); ?></td>
                            </tr>

                           
                            <tr>
                                <td>Quantity</td>
                                <td>
                                    <span class="grn-qty-badge"><?php echo $row2['s1']; ?> <?php echo $row2['unitm']; ?></span>
                                    <?php if ($row2['c1']): ?>
                                        <small>(Boxes: <?php echo $row2['box']; ?>)</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                           
                        </table>
                    </div>
                </div>
            </div>

            <!-- <div class="grn-footer">
            System generated GRN · Valid receipt
        </div> -->
        </div>
    </div>

    <!-- Remove old QR library and use a more reliable one -->
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    // Alternative: Use html5-qrcode or generate QR code using canvas
    function generateQRCode(text, elementId) {
        var canvas = document.createElement('canvas');
        var size = 150;
        canvas.width = size;
        canvas.height = size;
        var ctx = canvas.getContext('2d');
        
        // Simple QR code simulation using API
        var qrUrl = "https://quickchart.io/qr?text=" + encodeURIComponent(text) + "&size=" + size;
        
        var img = new Image();
        img.crossOrigin = "Anonymous";
        img.onload = function() {
            ctx.drawImage(img, 0, 0, size, size);
            var container = document.getElementById(elementId);
            container.innerHTML = '';
            container.appendChild(canvas);
        };
        img.src = qrUrl;
    }
  
    // Wait for page to load
    document.addEventListener("DOMContentLoaded", function() {
        var qrText = "<?php echo addslashes($qr_data); ?>";
        generateQRCode(qrText, 'qrcode');
    });

    function printRN() {
        var html = document.getElementById('printArea').innerHTML;
        var w = window.open('', '_blank');
        w.document.write('<html><head><title>GRN <?php echo $row2['grnno']; ?></title>');
        w.document.write('<style>');
        w.document.write('*{margin:0;padding:0;box-sizing:border-box;}');
        w.document.write('body{font-family:Arial,Helvetica,sans-serif;padding:20px;margin:0;background:white;}');
        w.document.write('.print-container{max-width:100%;margin:0 auto;}');
        
        /* Main heading styles */
        w.document.write('.grn-main-heading{text-align:center;margin-bottom:20px;}');
        w.document.write('.grn-main-heading h1{font-size:24px;color:#c0392b;margin:0;}');
        w.document.write('.grn-main-heading p{margin:5px 0 0;font-size:13px;color:#888;}');
        
        /* Bordered box */
        w.document.write('.grn-bordered-box{border:2px solid #000;border-radius:8px;overflow:hidden;margin-top:15px;}');
        
        /* Flex layout */
        w.document.write('.grn-split{display:flex;flex-wrap:wrap;}');
        
        /* QR side - responsive */
        w.document.write('.grn-qr-side{');
        w.document.write('background:#fafafa;');
        w.document.write('padding:20px;');
        w.document.write('text-align:center;');
        w.document.write('border-right:1px solid #ddd;');
        w.document.write('}');
        
        /* Data side */
        w.document.write('.grn-data-side{');
        w.document.write('padding:15px 20px;');
        w.document.write('}');
        
        /* Multiple size breakpoints */
        w.document.write('/* Extra small devices (phones, 480px and down) */');
        w.document.write('@media (max-width: 480px){');
        w.document.write('.grn-qr-side{width:100%;border-right:none;border-bottom:1px solid #ddd;}');
        w.document.write('.grn-data-side{width:100%;}');
        w.document.write('.grn-main-heading h1{font-size:18px;}');
        w.document.write('.grn-qr-side{padding:15px;}');
        w.document.write('.grn-data-side{padding:12px;}');
        w.document.write('td{font-size:12px;}');
        w.document.write('td:first-child{width:80px;}');
        w.document.write('}');
        
        w.document.write('/* Small devices (tablets, 481px to 768px) */');
        w.document.write('@media (min-width: 481px) and (max-width: 768px){');
        w.document.write('.grn-qr-side{width:35%;}');
        w.document.write('.grn-data-side{width:65%;}');
        w.document.write('.grn-main-heading h1{font-size:20px;}');
        w.document.write('td{font-size:13px;}');
        w.document.write('}');
        
        w.document.write('/* Medium devices (laptops, 769px to 1024px) */');
        w.document.write('@media (min-width: 769px) and (max-width: 1024px){');
        w.document.write('.grn-qr-side{width:30%;}');
        w.document.write('.grn-data-side{width:70%;}');
        w.document.write('}');
        
        w.document.write('/* Large devices (desktops, 1025px and up) */');
        w.document.write('@media (min-width: 1025px){');
        w.document.write('.grn-qr-side{width:28%;}');
        w.document.write('.grn-data-side{width:72%;}');
        w.document.write('}');
        
        /* Table styles */
        w.document.write('table{width:100%;border-collapse:collapse;}');
        w.document.write('tr{border-bottom:1px solid #eee;}');
        w.document.write('td{padding:8px 0;}');
        w.document.write('td:first-child{font-weight:bold;color:#555;}');
        w.document.write('td:last-child{color:#222;}');
        
        /* QR code image handling */
        w.document.write('#qrcode img{max-width:100%;height:auto;}');
        w.document.write('#qrcode canvas{max-width:100%;height:auto;}');
        
        /* Badge and footer */
        w.document.write('.grn-qty-badge{background:#f0f0f0;padding:2px 10px;display:inline-block;border-radius:15px;}');
        w.document.write('.grn-footer{text-align:center;font-size:10px;color:#aaa;margin-top:15px;padding-top:10px;border-top:1px solid #eee;}');
        
        /* Print-specific optimizations */
        w.document.write('@media print{');
        w.document.write('body{padding:0;margin:0;}');
        w.document.write('.grn-qr-side{-webkit-print-color-adjust:exact;print-color-adjust:exact;}');
        w.document.write('.grn-bordered-box{border:2px solid #000;margin-top:15px;}');
        w.document.write('@page{size:A4;margin:1.5cm;}');
        w.document.write('.grn-main-heading h1{font-size:22px;}');
        w.document.write('.grn-qr-side{width:30%;}');
        w.document.write('.grn-data-side{width:70%;}');
        w.document.write('td{padding:6px 0;}');
        w.document.write('}');
        
        w.document.write('@media print and (orientation:landscape){');
        w.document.write('.grn-qr-side{width:25%;}');
        w.document.write('.grn-data-side{width:75%;}');
        w.document.write('.grn-main-heading h1{font-size:20px;}');
        w.document.write('}');
        
        w.document.write('</style>');
        w.document.write('</head><body>');
        w.document.write('<div class="print-container">');
        w.document.write(html);
        w.document.write('</div>');
        w.document.write('</body></html>');
        w.document.close();
        
        setTimeout(function() {
            w.print();
            w.close();
        }, 100);
    }
</script>

</body>

</html>