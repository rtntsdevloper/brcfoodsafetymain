<?php

require __DIR__.'/barcode/BarcodeBase.php';
require __DIR__.'/barcode/QRCode.php';
require __DIR__.'/barcode/DataMatrix.php';
require __DIR__.'/barcode/Code39.php';
require __DIR__.'/barcode/Code128.php';

$bcode = array();

$bcode['c39']	= array('name' => 'Code39', 'obj' => new emberlabs\Barcode\Code39());
$bcode['c128']	= array('name' => 'Code128', 'obj' => new emberlabs\Barcode\Code128());

function bcode_error($m)
{
	echo "<div class='error'>{$m}</div>";
}

function bcode_success($bcode_name)
{
	echo "<div class='success'>A $bcode_name barcode was successfully created</div>";
}

function bcode_img64($b64str)
{
	echo "<img src='data:image/png;base64,$b64str' /><br />";
}

?>
<html>
<head>

<title>Barcode Tester</title>

<style type="text/css">
	.error, .success {
		margin: 20px 0 20px 0;
		font-weight: bold;
		padding: 15px;
		color: #FFF;
	}

	.error {
		background-color: #A00;
	}

	.success {
		background-color: #0A0;
	}
</style>

</head>
<body>

<form action="try" method="post">

Enter Data to encode: <input type="text" name="encode" value="<?php echo htmlspecialchars("sss"); ?>" /><br />
<input type="submit" value="Encode" name="submit" />

</form>

<hr />

<?php 

if (isset($_POST['submit'])) {

?>
Data to be encoded: <strong><?php echo htmlspecialchars("h"); ?></strong><br />

<?php
	foreach($bcode as $k => $value)
	{
		try
		{
			$bcode[$k]['obj']->setData("h");
			$bcode[$k]['obj']->setDimensions(300, 150);
			$bcode[$k]['obj']->draw();
			$b64 = $bcode[$k]['obj']->base64();

			bcode_success($bcode[$k]['name']);
			bcode_img64($b64);
		}
		catch (Exception $e)
		{
			bcode_error($e->getMessage());
		}
	}
?>

<?php } ?>

</body>
</html>
