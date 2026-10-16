<?php

$host = ""; 

$username = "hbsupply";  

$password = "Nisar59@@"; 

$database = "hbsupply_hfup1"; 

mysqli_connect("$host","$username","$password") or die("cannot connect");

mysqli_select_db("$database") or die("cannot select db");



date_default_timezone_set('Europe/London');

$curdate=date('Y-m-d');

$date = date_create($curdate);

$dt1 = date_format($date, 'd-m-Y');

$weekdt=date('d-m-Y', strtotime($curdate. ' - 7 days' ));



$date1 = date_create($weekdt);

$curdate1 = date_format($date1, 'Y-m-d');



require_once 'PHPExcel1/Classes/PHPExcel.php';

require_once 'PHPExcel1/Classes/PHPExcel/IOFactory.php';

$dt="26-01-2015";



// Create new PHPExcel object

$objPHPExcel = new PHPExcel();



// Create a first sheet, representing sales data

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HBH MEATS WEEKLY INVENTORY REPORT FROM '.$weekdt.' - '.$dt1);

                              

$objPHPExcel->getActiveSheet()->setCellValue('A4', 'PROD ID')

                              ->setCellValue('B4', 'PRODUCT')

                              ->setCellValue('C4', 'ENFIELD')

							  ->setCellValue('D4', 'HOUNSLOW')

                              ->setCellValue('E4', 'WEMBLEY')

                              ->setCellValue('F4', 'PARK ROYAL')

                              ->setCellValue('G4', 'ISLE OF DOGS')

                              ->setCellValue('H4', 'BECKTON')

                              ->setCellValue('I4', 'BARKING')	

                              ->setCellValue('J4', 'LEYTON')

                              ->setCellValue('K4', 'WALTHAMSTOW')

                              ->setCellValue('L4', 'EDMONTON')

                              ->setCellValue('M4', 'OLD KENT ROAD')

                              ->setCellValue('N4', 'SLOUGH')

                              ->setCellValue('O4', 'COLINDALE')	

                              ->setCellValue('P4', 'PECKHAM')	

                              ->setCellValue('Q4', 'WOKING')

                              ->setCellValue('R4', 'CHARLTON')

                              ->setCellValue('S4', 'PRESTON')

							  ->setCellValue('T4', 'KANAPINA')	

                              ->setCellValue('U4', 'TOTAL');							  						  							  							  						

$i=5;



$sql = mysqli_query($con,"select DISTINCT t1.prodname AS pname,t4.prodname AS fgname,t3.prodid, t3.prodtype,SUM(if(t3.consid='1',t3.qty,0))AS enfield ,SUM(if(t3.consid='2' ,t3.qty,0)) AS hounslow, SUM(if(t3.consid= '3',t3.qty,0))AS wembley,SUM(if(t3.consid= '4',t3.qty,0))AS park,SUM(if(t3.consid= '5',t3.qty,0))AS isle,SUM(if(t3.consid= '6',t3.qty,0))AS beckton,SUM(if(t3.consid= '7',t3.qty,0))AS barking,SUM(if(t3.consid= '8',t3.qty,0))AS leyton, SUM(if(t3.consid= '9',t3.qty,0))AS wstow, SUM(if(t3.consid= '10',t3.qty,0))AS edmonton,SUM(if(t3.consid= '11',t3.qty,0))AS kent,SUM(if(t3.consid= '12',t3.qty,0))AS slough, SUM(if(t3.consid= '13',t3.qty,0))AS cdale,SUM(if(t3.consid= '14',t3.qty,0))AS peckham, SUM(if(t3.consid= '15',t3.qty,0))AS woking,SUM(if(t3.consid= '16',t3.qty,0))AS charlton,SUM(if(t3.consid= '17',t3.qty,0))AS preston,SUM(if(t3.consid= '18',t3.qty,0))AS kanapina, SUM(t3.qty)  AS total from tblinventory t3,tblproduct t1,tblfgproduct t4 where t3.prodid=t1.prodid AND t3.prodid=t4.prodid   AND  t3.stkdate BETWEEN '$curdate1' AND '$curdate'     GROUP BY t3.prodid");

 while($r = mysqli_fetch_array($sql))

 {

 $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $r['prodid'])

                              ->setCellValue('B'.$i, (($r['prodtype']=='FG')?$r['fgname']:$r['pname']))

                              ->setCellValue('C'.$i, round($r['enfield'],1))

							  ->setCellValue('D'.$i, round($r['hounslow'],1))

                              ->setCellValue('E'.$i, round($r['wembley'],1))

                              ->setCellValue('F'.$i, round($r['park'],1))

                              ->setCellValue('G'.$i, round($r['isle'],1))

                              ->setCellValue('H'.$i, round($r['beckton'],1))

                              ->setCellValue('I'.$i, round($r['barking'],1))	

                              ->setCellValue('J'.$i, round($r['leyton'],1))

                              ->setCellValue('K'.$i, round($r['wstow'],1))

                              ->setCellValue('L'.$i, round($r['edmonton'],1))

                              ->setCellValue('M'.$i, round($r['kent'],1))

                              ->setCellValue('N'.$i, round($r['slough'],1))

                              ->setCellValue('O'.$i, round($r['cdale'],1))	

                              ->setCellValue('P'.$i, round($r['peckham'],1))	

                              ->setCellValue('Q'.$i, round($r['woking'],1))

                              ->setCellValue('R'.$i, round($r['charlton'],1))

                              ->setCellValue('S'.$i, round($r['preston'],1))

							  ->setCellValue('T'.$i, round($r['kanapina'],1))	

                              ->setCellValue('U'.$i, round($r['total'],1));	

							  $i++;						  						  							  							  						

}							    						  							  							  							  							  							  $k=$i;

$sql1 = mysqli_query($con,"select SUM(if(consid='1',qty,0))AS enfield1 , SUM(if(consid='2' ,qty,0)) AS hounslow1,SUM(if(consid= '3',qty,0))AS wembley1,SUM(if(consid= '4',qty,0))AS park1,SUM(if(consid= '5',qty,0))AS isle1,SUM(if(consid= '6',qty,0))AS beckton1,SUM(if(consid= '7',qty,0))AS barking1,SUM(if(consid= '8',qty,0))AS leyton1, SUM(if(consid= '9',qty,0))AS wstow1, SUM(if(consid= '10',qty,0))AS edmonton1, SUM(if(consid= '11',qty,0))AS kent1,SUM(if(consid= '12',qty,0))AS slough1,SUM(if(consid= '13',qty,0))AS cdale1,

 SUM(if(consid= '14',qty,0))AS peckham1, SUM(if(consid= '15',qty,0))AS woking1,SUM(if(consid= '16',qty,0))AS charlton1,SUM(if(consid= '17',qty,0))AS preston1,SUM(if(consid= '18',qty,0))AS kanapina1, SUM(qty)  AS gtotal from tblinventory where stkdate BETWEEN '$curdate1' AND '$curdate'");

 $r0 = mysqli_fetch_array($sql1);



 $objPHPExcel->getActiveSheet()->setCellValue('A'.$k,'TOTAL')

                               ->setCellValue('B'.$k,'')

							   ->setCellValue('C'.$k,round($r0['enfield1'],1))

							  ->setCellValue('D'.$k, round($r0['hounslow1'],1))

                              ->setCellValue('E'.$k, round($r0['wembley1'],1))

                              ->setCellValue('F'.$k, round($r0['park1'],1))

                              ->setCellValue('G'.$k, round($r0['isle1'],1))

                              ->setCellValue('H'.$k, round($r0['beckton1'],1))

                              ->setCellValue('I'.$k, round($r0['barking1'],1))	

                              ->setCellValue('J'.$k, round($r0['leyton1'],1))

                              ->setCellValue('K'.$k, round($r0['wstow1'],1))

                              ->setCellValue('L'.$k, round($r0['edmonton1'],1))

                              ->setCellValue('M'.$k, round($r0['kent1'],1))

                              ->setCellValue('N'.$k, round($r0['slough1'],1))

                              ->setCellValue('O'.$k, round($r0['cdale1'],1))	

                              ->setCellValue('P'.$k, round($r0['peckham1'],1))	

                              ->setCellValue('Q'.$k, round($r0['woking1'],1))

                              ->setCellValue('R'.$k, round($r0['charlton1'],1))

                              ->setCellValue('S'.$k, round($r0['preston1'],1))

							  ->setCellValue('T'.$k, round($r0['kanapina1'],1))	

                              ->setCellValue('U'.$k, round($r0['gtotal'],1));	

// Rename sheet

$objPHPExcel->getActiveSheet()->setTitle('Inventory');



// Create a new worksheet, after the default sheet

$objPHPExcel->createSheet();



// Add some data to the second sheet, resembling some different data types

$objPHPExcel->setActiveSheetIndex(1);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HBH MEATS WEEKLY DESPATCHES REPORT  FROM '.$weekdt.' - '.$dt1);

$objPHPExcel->getActiveSheet()->setCellValue('A4', 'PROD ID')

                              ->setCellValue('B4', 'PRODUCT')

                              ->setCellValue('C4', 'ENFIELD')

							  ->setCellValue('D4', 'HOUNSLOW')

                              ->setCellValue('E4', 'WEMBLEY')

                              ->setCellValue('F4', 'PARK ROYAL')

                              ->setCellValue('G4', 'ISLE OF DOGS')

                              ->setCellValue('H4', 'BECKTON')

                              ->setCellValue('I4', 'BARKING')	

                              ->setCellValue('J4', 'LEYTON')

                              ->setCellValue('K4', 'WALTHAMSTOW')

                              ->setCellValue('L4', 'EDMONTON')

                              ->setCellValue('M4', 'OLD KENT ROAD')

                              ->setCellValue('N4', 'SLOUGH')

                              ->setCellValue('O4', 'COLINDALE')	

                              ->setCellValue('P4', 'PECKHAM')	

                              ->setCellValue('Q4', 'WOKING')

                              ->setCellValue('R4', 'CHARLTON')

                              ->setCellValue('S4', 'PRESTON')

							  ->setCellValue('T4', 'KANAPINA')	

                              ->setCellValue('U4', 'TOTAL');

				

$objPHPExcel->getActiveSheet()->setCellValue('A5', '')

                              ->setCellValue('B5', '')

                              ->setCellValue('C5', 'Tray|Qty')

							  ->setCellValue('D5', 'Tray|Qty')

                              ->setCellValue('E5', 'Tray|Qty')

                              ->setCellValue('F5', 'Tray|Qty')

                              ->setCellValue('G5', 'Tray|Qty')

                              ->setCellValue('H5', 'Tray|Qty')

                              ->setCellValue('I5', 'Tray|Qty')	

                              ->setCellValue('J5', 'Tray|Qty')

                              ->setCellValue('K5', 'Tray|Qty')

                              ->setCellValue('L5', 'Tray|Qty')

                              ->setCellValue('M5', 'Tray|Qty')

                              ->setCellValue('N5', 'Tray|Qty')

                              ->setCellValue('O5', 'Tray|Qty')	

                              ->setCellValue('P5', 'Tray|Qty')	

                              ->setCellValue('Q5', 'Tray|Qty')

                              ->setCellValue('R5', 'Tray|Qty')

                              ->setCellValue('S5', 'Tray|Qty')

							  ->setCellValue('T5', 'Tray|Qty')	

                              ->setCellValue('U5', 'Tray|Qty');							  						  							  							  						

							  						  							  							  						

$i1=6;



 $xy=mysqli_query($con,"create VIEW tbldespatch AS select t1.gdnno,t1.consid,t2.prodid,t2.qty from tblgdndetails t1,tblgdnitems t2 where t1.gdnno=t2.gdnno and date(t1.gddttime) BETWEEN '$curdate1' AND '$curdate'");

	 $sq1 = mysqli_query($con,"select DISTINCT t1.prodname,t1.supid,t2.prodid ,t3.sagecode,

	                                 COUNT(if(t2.consid='1',t2.qty,NULL))AS c1 , COUNT(if(t2.consid='2',t2.qty,NULL))AS c2 ,COUNT(if(t2.consid='3',t2.qty,NULL))AS c3 ,COUNT(if(t2.consid='4',t2.qty,NULL))AS c4 ,COUNT(if(t2.consid='5',t2.qty,NULL))AS c5 ,COUNT(if(t2.consid='6',t2.qty,NULL))AS c6 ,COUNT(if(t2.consid='7',t2.qty,NULL))AS c7 ,COUNT(if(t2.consid='8',t2.qty,NULL))AS c8 ,COUNT(if(t2.consid='9',t2.qty,NULL))AS c9 ,COUNT(if(t2.consid='10',t2.qty,NULL))AS c10 ,COUNT(if(t2.consid='11',t2.qty,NULL))AS c11 ,COUNT(if(t2.consid='12',t2.qty,NULL))AS c12 ,COUNT(if(t2.consid='13',t2.qty,NULL))AS c13 ,COUNT(if(t2.consid='14',t2.qty,NULL))AS c14 ,COUNT(if(t2.consid='15',t2.qty,NULL))AS c15 ,COUNT(if(t2.consid='16',t2.qty,NULL))AS c16 ,COUNT(if(t2.consid='17',t2.qty,NULL))AS c17 ,COUNT(if(t2.consid='18',t2.qty,NULL))AS c18 ,SUM(if(t2.consid='1',t2.qty,0))AS enfield ,SUM(if(t2.consid='2' ,t2.qty,0)) AS hounslow, SUM(if(t2.consid= '3',t2.qty,0))AS wembley,SUM(if(t2.consid= '4',t2.qty,0))AS park, SUM(if(t2.consid= '5',t2.qty,0))AS isle,SUM(if(t2.consid= '6',t2.qty,0))AS beckton, SUM(if(t2.consid= '7',t2.qty,0))AS barking,SUM(if(t2.consid= '8',t2.qty,0))AS leyton,SUM(if(t2.consid= '9',t2.qty,0))AS wstow,SUM(if(t2.consid= '10',t2.qty,0))AS edmonton,SUM(if(t2.consid= '11',t2.qty,0))AS kent,SUM(if(t2.consid= '12',t2.qty,0))AS slough,SUM(if(t2.consid= '13',t2.qty,0))AS cdale,SUM(if(t2.consid= '14',t2.qty,0))AS peckham, SUM(if(t2.consid= '15',t2.qty,0))AS woking, SUM(if(t2.consid= '16',t2.qty,0))AS charlton,SUM(if(t2.consid= '17',t2.qty,0))AS preston,SUM(if(t2.consid= '18',t2.qty,0))AS kanapina, 

SUM(t2.qty)  AS total,COUNT(t2.qty)  AS total1  from tbldespatch t2,tblproduct t1,tblsupplier t3 where t1.prodid=t2.prodid AND t1.supid=t3.supid GROUP BY t2.prodid");

									

									  while($u=mysqli_fetch_array($sq1))

		{

 $objPHPExcel->getActiveSheet()->setCellValue('A'.$i1, $u['sagecode'])

                              ->setCellValue('B'.$i1, $u['prodname'])

                              ->setCellValue('C'.$i1, $u['c1'].'|'.round($u['enfield'],1))

							  ->setCellValue('D'.$i1, $u['c2'].'|'.round($u['hounslow'],1))

                              ->setCellValue('E'.$i1, $u['c3'].'|'.round($u['wembley'],1))

                              ->setCellValue('F'.$i1, $u['c4'].'|'.round($u['park'],1))

                              ->setCellValue('G'.$i1, $u['c5'].'|'.round($u['isle'],1))

                              ->setCellValue('H'.$i1, $u['c6'].'|'.round($u['beckton'],1))

                              ->setCellValue('I'.$i1, $u['c7'].'|'.round($u['barking'],1))	

                              ->setCellValue('J'.$i1, $u['c8'].'|'.round($u['leyton'],1))

                              ->setCellValue('K'.$i1, $u['c9'].'|'.round($u['wstow'],1))

                              ->setCellValue('L'.$i1, $u['c10'].'|'.round($u['edmonton'],1))

                              ->setCellValue('M'.$i1, $u['c11'].'|'.round($u['kent'],1))

                              ->setCellValue('N'.$i1, $u['c12'].'|'.round($u['slough'],1))

                              ->setCellValue('O'.$i1, $u['c13'].'|'.round($u['cdale'],1))	

                              ->setCellValue('P'.$i1, $u['c14'].'|'.round($u['peckham'],1))	

                              ->setCellValue('Q'.$i1, $u['c15'].'|'.round($u['woking'],1))

                              ->setCellValue('R'.$i1, $u['c16'].'|'.round($u['charlton'],1))

                              ->setCellValue('S'.$i1, $u['c17'].'|'.round($u['preston'],1))

							  ->setCellValue('T'.$i1, $u['c18'].'|'.round($u['kanapina'],1))	

                              ->setCellValue('U'.$i1, $u['total1'].'|'.round($u['total'],1));	

							  $i1++;						  						  							  							  						

}

$k1=$i1;



 $sq2 = mysqli_query($con,"select qty ,

	                                 COUNT(if(consid='1',qty,NULL))AS tc1 , COUNT(if(consid='2',qty,NULL))AS tc2 ,COUNT(if(consid='3',qty,NULL))AS tc3 ,COUNT(if(consid='4',qty,NULL))AS tc4 ,COUNT(if(consid='5',qty,NULL))AS tc5 ,COUNT(if(consid='6',qty,NULL))AS tc6 ,COUNT(if(consid='7',qty,NULL))AS tc7 ,COUNT(if(consid='8',qty,NULL))AS tc8 ,COUNT(if(consid='9',qty,NULL))AS tc9 ,COUNT(if(consid='10',qty,NULL))AS tc10 ,COUNT(if(consid='11',qty,NULL))AS tc11 ,COUNT(if(consid='12',qty,NULL))AS tc12 ,COUNT(if(consid='13',qty,NULL))AS tc13 ,COUNT(if(consid='14',qty,NULL))AS tc14 ,COUNT(if(consid='15',qty,NULL))AS tc15 ,COUNT(if(consid='16',qty,NULL))AS tc16 ,COUNT(if(consid='17',qty,NULL))AS tc17 ,COUNT(if(consid='18',qty,NULL))AS tc18 , SUM(if(consid='1',qty,0))AS enfield1 ,

 SUM(if(consid='2' ,qty,0)) AS hounslow1, SUM(if(consid= '3',qty,0))AS wembley1, SUM(if(consid= '4',qty,0))AS park1,SUM(if(consid= '5',qty,0))AS isle1, SUM(if(consid= '6',qty,0))AS beckton1,SUM(if(consid= '7',qty,0))AS barking1, SUM(if(consid= '8',qty,0))AS leyton1,SUM(if(consid= '9',qty,0))AS wstow1,SUM(if(consid= '10',qty,0))AS edmonton1, SUM(if(consid= '11',qty,0))AS kent1, SUM(if(consid= '12',qty,0))AS slough1,SUM(if(consid= '13',qty,0))AS cdale1,SUM(if(consid= '14',qty,0))AS peckham1,  SUM(if(consid= '15',qty,0))AS woking1,SUM(if(consid= '16',qty,0))AS charlton1, SUM(if(consid= '17',qty,0))AS preston1,  SUM(if(consid= '18',qty,0))AS kanapina1, SUM(qty)  AS gtotal,COUNT(qty)  AS gtotal1 from tbldespatch");

$r1 = mysqli_fetch_array($sq2);



$objPHPExcel->getActiveSheet()->setCellValue('A'.$k1, 'TOTAL')

                              ->setCellValue('B'.$k1, '')

                              ->setCellValue('C'.$k1, $r1['tc1'].'|'.round($r1['enfield1'],1))

							  ->setCellValue('D'.$k1, $r1['tc2'].'|'.round($r1['hounslow1'],1))

                              ->setCellValue('E'.$k1, $r1['tc3'].'|'.round($r1['wembley1'],1))

                              ->setCellValue('F'.$k1, $r1['tc4'].'|'.round($r1['park1'],1))

                              ->setCellValue('G'.$k1, $r1['tc5'].'|'.round($r1['isle1'],1))

                              ->setCellValue('H'.$k1, $r1['tc6'].'|'.round($r1['beckton1'],1))

                              ->setCellValue('I'.$k1, $r1['tc7'].'|'.round($r1['barking1'],1))	

                              ->setCellValue('J'.$k1, $r1['tc8'].'|'.round($r1['leyton1'],1))

                              ->setCellValue('K'.$k1, $r1['tc9'].'|'.round($r1['wstow1'],1))

                              ->setCellValue('L'.$k1, $r1['tc10'].'|'.round($r1['edmonton1'],1))

                              ->setCellValue('M'.$k1, $r1['tc11'].'|'.round($r1['kent1'],1))

                              ->setCellValue('N'.$k1, $r1['tc12'].'|'.round($r1['slough1'],1))

                              ->setCellValue('O'.$k1, $r1['tc13'].'|'.round($r1['cdale1'],1))	

                              ->setCellValue('P'.$k1, $r1['tc14'].'|'.round($r1['peckham1'],1))	

                              ->setCellValue('Q'.$k1, $r1['tc15'].'|'.round($r1['woking1'],1))

                              ->setCellValue('R'.$k1, $r1['tc16'].'|'.round($r1['charlton1'],1))

                              ->setCellValue('S'.$k1, $r1['tc17'].'|'.round($r1['preston1'],1))

							  ->setCellValue('T'.$k1, $r1['tc18'].'|'.round($r1['kanapina1'],1))	

                              ->setCellValue('U'.$k1, $r1['gtotal1'].'|'.round($r1['gtotal'],1));

							  $xx = mysqli_query($con,"DROP VIEW tbldespatch");	

// Rename 2nd sheet

$objPHPExcel->getActiveSheet()->setTitle('Despatches');

// prod sheet



$objPHPExcel->createSheet();



// Add some data to the second sheet, resembling some different data types

$objPHPExcel->setActiveSheetIndex(2);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HBH MEATS WEEKLY PRODUCTION REPORT  FROM '.$weekdt.' - '.$dt1);

$objPHPExcel->getActiveSheet()->setCellValue('A4', 'SUPPLIER')

                              ->setCellValue('B4', 'PROD ID')

                              ->setCellValue('C4', 'PRODUCT')

                              ->setCellValue('D4', 'QUANTITY')

                              ->setCellValue('E4', 'UOM')

                              ->setCellValue('F4', 'USE BY');

                              

				

$m=5;



	 $s1 = mysqli_query($con,"select t1.prodname,t1.shelfdays,t1.supid,t1.uom,t2.*,SUM(t2.quantity) AS qty,date(lbldate) AS lbdate,t3.sagecode from tblproduct t1,tblwiplabels t2,tblsupplier t3  where t2.prodid=t1.prodid AND t1.supid=t3.supid AND   date(lbldate) BETWEEN '$curdate1' AND '$curdate'  GROUP BY t2.prodid");

									

									  while($t1=mysqli_fetch_array($s1))

		{

 $objPHPExcel->getActiveSheet()->setCellValue('A'.$m, $t1['sagecode'])

                              ->setCellValue('B'.$m, $t1['prodid'])

                              ->setCellValue('C'.$m, $t1['prodname'])

							  ->setCellValue('D'.$m, round($t1['qty'],1))

                              ->setCellValue('E'.$m, (($t1['uom']=="K")?"Kgs":"Pcs"))

                              ->setCellValue('F'.$m, date('d-m-Y', strtotime($t1['lbdate']. ' + '.$t1['shelfdays'].' days' )));

                             

							  $m++;						  						  							  							  						

}



// Rename 2nd sheet

$objPHPExcel->getActiveSheet()->setTitle('Production');

// Redirect output to a client’s web browser (Excel5)

//GOODS IN

$objPHPExcel->createSheet();



// Add some data to the second sheet, resembling some different data types

$objPHPExcel->setActiveSheetIndex(3);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HBH MEATS WEEKLY GOODS IN REPORT  FROM '.$weekdt.' - '.$dt1);

$objPHPExcel->getActiveSheet()->setCellValue('A4', 'SUPPLIER')

                              ->setCellValue('B4', 'PRODUCT')

                              ->setCellValue('C4', 'ENFIELD')

							  ->setCellValue('D4', 'HOUNSLOW')

                              ->setCellValue('E4', 'WEMBLEY')

                              ->setCellValue('F4', 'PARK ROYAL')

                              ->setCellValue('G4', 'ISLE OF DOGS')

                              ->setCellValue('H4', 'BECKTON')

                              ->setCellValue('I4', 'BARKING')	

                              ->setCellValue('J4', 'LEYTON')

                              ->setCellValue('K4', 'WALTHAMSTOW')

                              ->setCellValue('L4', 'EDMONTON')

                              ->setCellValue('M4', 'OLD KENT ROAD')

                              ->setCellValue('N4', 'SLOUGH')

                              ->setCellValue('O4', 'COLINDALE')	

                              ->setCellValue('P4', 'PECKHAM')	

                              ->setCellValue('Q4', 'WOKING')

                              ->setCellValue('R4', 'CHARLTON')

                              ->setCellValue('S4', 'PRESTON')

							  ->setCellValue('T4', 'KANAPINA')	

                              ->setCellValue('U4', 'TOTAL');

				

$objPHPExcel->getActiveSheet()->setCellValue('A5', '')

                              ->setCellValue('B5', '')

                              ->setCellValue('C5', 'Tray|Qty')

							  ->setCellValue('D5', 'Tray|Qty')

                              ->setCellValue('E5', 'Tray|Qty')

                              ->setCellValue('F5', 'Tray|Qty')

                              ->setCellValue('G5', 'Tray|Qty')

                              ->setCellValue('H5', 'Tray|Qty')

                              ->setCellValue('I5', 'Tray|Qty')	

                              ->setCellValue('J5', 'Tray|Qty')

                              ->setCellValue('K5', 'Tray|Qty')

                              ->setCellValue('L5', 'Tray|Qty')

                              ->setCellValue('M5', 'Tray|Qty')

                              ->setCellValue('N5', 'Tray|Qty')

                              ->setCellValue('O5', 'Tray|Qty')	

                              ->setCellValue('P5', 'Tray|Qty')	

                              ->setCellValue('Q5', 'Tray|Qty')

                              ->setCellValue('R5', 'Tray|Qty')

                              ->setCellValue('S5', 'Tray|Qty')

							  ->setCellValue('T5', 'Tray|Qty')	

                              ->setCellValue('U5', 'Tray|Qty');							  						  							  							  						

							  						  							  							  						

$n=6;



$xy1=mysqli_query($con,"create VIEW tblgoodsin AS select t1.grnno,t1.consid,t1.supid,t2.prodid,t2.quantity from tblgrnlist t1,tblgrnitems t2 where t1.grnno=t2.grnno and date(t1.grdttime)  BETWEEN '$curdate1' AND '$curdate' ");

	$s2 = mysqli_query($con,"select DISTINCT t1.prodname,t2.quantity ,t3.sagecode,

	                                 COUNT(if(consid='1',t2.quantity,NULL))AS c1 , COUNT(if(consid='2',t2.quantity,NULL))AS c2 ,COUNT(if(consid='3',t2.quantity,NULL))AS c3 ,COUNT(if(consid='4',t2.quantity,NULL))AS c4 ,COUNT(if(consid='5',t2.quantity,NULL))AS c5 ,COUNT(if(consid='6',t2.quantity,NULL))AS c6 ,COUNT(if(consid='7',t2.quantity,NULL))AS c7 ,COUNT(if(consid='8',t2.quantity,NULL))AS c8 ,COUNT(if(consid='9',t2.quantity,NULL))AS c9 ,COUNT(if(consid='10',t2.quantity,NULL))AS c10 ,COUNT(if(consid='11',t2.quantity,NULL))AS c11 ,COUNT(if(consid='12',t2.quantity,NULL))AS c12 ,COUNT(if(consid='13',t2.quantity,NULL))AS c13 ,COUNT(if(consid='14',t2.quantity,NULL))AS c14 ,COUNT(if(consid='15',t2.quantity,NULL))AS c15 ,COUNT(if(consid='16',t2.quantity,NULL))AS c16 ,COUNT(if(consid='17',t2.quantity,NULL))AS c17 ,COUNT(if(consid='18',t2.quantity,NULL))AS c18 ,SUM(if(consid='1',t2.quantity,0))AS enfield , SUM(if(consid='2' ,t2.quantity,0)) AS hounslow, SUM(if(consid= '3',t2.quantity,0))AS wembley, SUM(if(consid= '4',t2.quantity,0))AS park, SUM(if(consid= '5',t2.quantity,0))AS isle,SUM(if(consid= '6',t2.quantity,0))AS beckton, SUM(if(consid= '7',t2.quantity,0))AS barking,SUM(if(consid= '8',t2.quantity,0))AS leyton,  SUM(if(consid= '9',t2.quantity,0))AS wstow,SUM(if(consid= '10',t2.quantity,0))AS edmonton, SUM(if(consid= '11',t2.quantity,0))AS kent,SUM(if(consid= '12',t2.quantity,0))AS slough, SUM(if(consid= '13',t2.quantity,0))AS cdale, SUM(if(consid= '14',t2.quantity,0))AS peckham,SUM(if(consid= '15',t2.quantity,0))AS woking, SUM(if(consid= '16',t2.quantity,0))AS charlton, SUM(if(consid= '17',t2.quantity,0))AS preston,SUM(if(consid= '18',t2.quantity,0))AS kanapina,  SUM(t2.quantity)  AS total,COUNT(t2.quantity)  AS total1 from tblgoodsin t2,tblproduct t1 ,tblsupplier t3 where t2.prodid=t1.prodid AND t2.supid=t3.supid  GROUP BY t2.prodid  ORDER BY t2.supid ASC");

									

									  while($t2=mysqli_fetch_array($s2))

		{

 $objPHPExcel->getActiveSheet()->setCellValue('A'.$n, $t2['sagecode'])

                              ->setCellValue('B'.$n, $t2['prodname'])

                              ->setCellValue('C'.$n, $t2['c1'].'|'.round($t2['enfield'],1))

							  ->setCellValue('D'.$n, $t2['c2'].'|'.round($t2['hounslow'],1))

                              ->setCellValue('E'.$n, $t2['c3'].'|'.round($t2['wembley'],1))

                              ->setCellValue('F'.$n, $t2['c4'].'|'.round($t2['park'],1))

                              ->setCellValue('G'.$n, $t2['c5'].'|'.round($t2['isle'],1))

                              ->setCellValue('H'.$n, $t2['c6'].'|'.round($t2['beckton'],1))

                              ->setCellValue('I'.$n, $t2['c7'].'|'.round($t2['barking'],1))	

                              ->setCellValue('J'.$n, $t2['c8'].'|'.round($t2['leyton'],1))

                              ->setCellValue('K'.$n, $t2['c9'].'|'.round($t2['wstow'],1))

                              ->setCellValue('L'.$n, $t2['c10'].'|'.round($t2['edmonton'],1))

                              ->setCellValue('M'.$n, $t2['c11'].'|'.round($t2['kent'],1))

                              ->setCellValue('N'.$n, $t2['c12'].'|'.round($t2['slough'],1))

                              ->setCellValue('O'.$n, $t2['c13'].'|'.round($t2['cdale'],1))	

                              ->setCellValue('P'.$n, $t2['c14'].'|'.round($t2['peckham'],1))	

                              ->setCellValue('Q'.$n, $t2['c15'].'|'.round($t2['woking'],1))

                              ->setCellValue('R'.$n, $t2['c16'].'|'.round($t2['charlton'],1))

                              ->setCellValue('S'.$n, $t2['c17'].'|'.round($t2['preston'],1))

							  ->setCellValue('T'.$n, $t2['c18'].'|'.round($t2['kanapina'],1))	

                              ->setCellValue('U'.$n, $t2['total1'].'|'.round($t2['total'],1));	

							  $n++;						  						  							  							  						

}

$k2=$n;



 $s3 = mysqli_query($con,"select quantity ,

	                                 COUNT(if(consid='1',quantity,NULL))AS tc1 , COUNT(if(consid='2',quantity,NULL))AS tc2 ,COUNT(if(consid='3',quantity,NULL))AS tc3 ,COUNT(if(consid='4',quantity,NULL))AS tc4 ,COUNT(if(consid='5',quantity,NULL))AS tc5 ,COUNT(if(consid='6',quantity,NULL))AS tc6 ,COUNT(if(consid='7',quantity,NULL))AS tc7 ,COUNT(if(consid='8',quantity,NULL))AS tc8 ,COUNT(if(consid='9',quantity,NULL))AS tc9 ,COUNT(if(consid='10',quantity,NULL))AS tc10 ,COUNT(if(consid='11',quantity,NULL))AS tc11 ,COUNT(if(consid='12',quantity,NULL))AS tc12 ,COUNT(if(consid='13',quantity,NULL))AS tc13 ,COUNT(if(consid='14',quantity,NULL))AS tc14 ,COUNT(if(consid='15',quantity,NULL))AS tc15 ,COUNT(if(consid='16',quantity,NULL))AS tc16 ,COUNT(if(consid='17',quantity,NULL))AS tc17 ,COUNT(if(consid='18',quantity,NULL))AS tc18 , SUM(if(consid='1',quantity,0))AS enfield1 ,

 SUM(if(consid='2' ,quantity,0)) AS hounslow1, SUM(if(consid= '3',quantity,0))AS wembley1, SUM(if(consid= '4',quantity,0))AS park1,SUM(if(consid= '5',quantity,0))AS isle1, SUM(if(consid= '6',quantity,0))AS beckton1,SUM(if(consid= '7',quantity,0))AS barking1, SUM(if(consid= '8',quantity,0))AS leyton1,SUM(if(consid= '9',quantity,0))AS wstow1,SUM(if(consid= '10',quantity,0))AS edmonton1, SUM(if(consid= '11',quantity,0))AS kent1, SUM(if(consid= '12',quantity,0))AS slough1,SUM(if(consid= '13',quantity,0))AS cdale1,SUM(if(consid= '14',quantity,0))AS peckham1,  SUM(if(consid= '15',quantity,0))AS woking1,SUM(if(consid= '16',quantity,0))AS charlton1, SUM(if(consid= '17',quantity,0))AS preston1,  SUM(if(consid= '18',quantity,0))AS kanapina1, SUM(quantity)  AS gtotal,COUNT(quantity)  AS gtotal1 from tblgoodsin");

$t3 = mysqli_fetch_array($s3);



$objPHPExcel->getActiveSheet()->setCellValue('A'.$k2, 'TOTAL')

                              ->setCellValue('B'.$k2, '')

                              ->setCellValue('C'.$k2, $t3['tc1'].'|'.round($t3['enfield1'],1))

							  ->setCellValue('D'.$k2, $t3['tc2'].'|'.round($t3['hounslow1'],1))

                              ->setCellValue('E'.$k2, $t3['tc3'].'|'.round($t3['wembley1'],1))

                              ->setCellValue('F'.$k2, $t3['tc4'].'|'.round($t3['park1'],1))

                              ->setCellValue('G'.$k2, $t3['tc5'].'|'.round($t3['isle1'],1))

                              ->setCellValue('H'.$k2, $t3['tc6'].'|'.round($t3['beckton1'],1))

                              ->setCellValue('I'.$k2, $t3['tc7'].'|'.round($t3['barking1'],1))	

                              ->setCellValue('J'.$k2, $t3['tc8'].'|'.round($t3['leyton1'],1))

                              ->setCellValue('K'.$k2, $t3['tc9'].'|'.round($t3['wstow1'],1))

                              ->setCellValue('L'.$k2, $t3['tc10'].'|'.round($t3['edmonton1'],1))

                              ->setCellValue('M'.$k2, $t3['tc11'].'|'.round($t3['kent1'],1))

                              ->setCellValue('N'.$k2, $t3['tc12'].'|'.round($t3['slough1'],1))

                              ->setCellValue('O'.$k2, $t3['tc13'].'|'.round($t3['cdale1'],1))	

                              ->setCellValue('P'.$k2, $t3['tc14'].'|'.round($t3['peckham1'],1))	

                              ->setCellValue('Q'.$k2, $t3['tc15'].'|'.round($t3['woking1'],1))

                              ->setCellValue('R'.$k2, $t3['tc16'].'|'.round($t3['charlton1'],1))

                              ->setCellValue('S'.$k2, $t3['tc17'].'|'.round($t3['preston1'],1))

							  ->setCellValue('T'.$k2, $t3['tc18'].'|'.round($t3['kanapina1'],1))	

                              ->setCellValue('U'.$k2, $t3['gtotal1'].'|'.round($t3['gtotal'],1));

							  $x7 = mysqli_query($con,"DROP VIEW tblgoodsin");	

// Rename 2nd sheet

$objPHPExcel->getActiveSheet()->setTitle('Goods in');



$objPHPExcel->createSheet();



// Add some data to the second sheet, resembling some different data types

$objPHPExcel->setActiveSheetIndex(4);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HBH MEATS WEEKLY ORDER REPORT  FROM '.$weekdt.' - '.$dt1);

$objPHPExcel->getActiveSheet()->setCellValue('A4', 'SUPPLIER')

                              ->setCellValue('B4', 'PRODUCT')

                              ->setCellValue('C4', 'ENFIELD')

							  ->setCellValue('D4', 'HOUNSLOW')

                              ->setCellValue('E4', 'WEMBLEY')

                              ->setCellValue('F4', 'PARK ROYAL')

                              ->setCellValue('G4', 'ISLE OF DOGS')

                              ->setCellValue('H4', 'BECKTON')

                              ->setCellValue('I4', 'BARKING')	

                              ->setCellValue('J4', 'LEYTON')

                              ->setCellValue('K4', 'WALTHAMSTOW')

                              ->setCellValue('L4', 'EDMONTON')

                              ->setCellValue('M4', 'OLD KENT ROAD')

                              ->setCellValue('N4', 'SLOUGH')

                              ->setCellValue('O4', 'COLINDALE')	

                              ->setCellValue('P4', 'PECKHAM')	

                              ->setCellValue('Q4', 'WOKING')

                              ->setCellValue('R4', 'CHARLTON')

                              ->setCellValue('S4', 'PRESTON')

							  ->setCellValue('T4', 'KANAPINA')	

                              ->setCellValue('U4', 'TOTAL');

				

						  						  							  							  						

							  						  							  							  						

$g=5;



$xy4=mysqli_query($con,"create VIEW tblorder AS select t1.ordno,t1.consid,t2.prodid,t2.qty,t2.supid from tblordlist t1,tblorddetails t2 where t1.ordno=t2.ordno and date(t1.orddt) BETWEEN '$curdate1' AND '$curdate'");	

	$s4 = mysqli_query($con,"select DISTINCT  t1.prodname,t2.supid ,t3.sagecode, SUM(if(consid='1',t2.qty,0))AS enfield ,SUM(if(consid='2' ,t2.qty,0)) AS hounslow,SUM(if(consid= '3',t2.qty,0))AS wembley,SUM(if(consid= '4',t2.qty,0))AS park,SUM(if(consid= '5',t2.qty,0))AS isle,SUM(if(consid= '6',t2.qty,0))AS beckton,SUM(if(consid= '7',t2.qty,0))AS barking,SUM(if(consid= '8',t2.qty,0))AS leyton,SUM(if(consid= '9',t2.qty,0))AS wstow,SUM(if(consid= '10',t2.qty,0))AS edmonton,SUM(if(consid= '11',t2.qty,0))AS kent,SUM(if(consid= '12',t2.qty,0))AS slough,SUM(if(consid= '13',t2.qty,0))AS cdale,SUM(if(consid= '14',t2.qty,0))AS peckham,SUM(if(consid= '15',t2.qty,0))AS woking,SUM(if(consid= '16',t2.qty,0))AS charlton,SUM(if(consid= '17',t2.qty,0))AS preston,SUM(if(consid= '18',t2.qty,0))AS kanapina, SUM(t2.qty)  AS total,COUNT(t2.qty)  AS total1  from tblorder t2,tblproduct t1,tblsupplier t3 where t1.prodid=t2.prodid AND t2.supid=t3.supid GROUP BY t2.prodid ORDER BY t2.supid ASC");

									

									  while($t4=mysqli_fetch_array($s4))

		{

$objPHPExcel->getActiveSheet()->setCellValue('A'.$g, $t4['sagecode'])

                              ->setCellValue('B'.$g, $t4['prodname'])

                              ->setCellValue('C'.$g, round($t4['enfield'],1))

							  ->setCellValue('D'.$g, round($t4['hounslow'],1))

                              ->setCellValue('E'.$g, round($t4['wembley'],1))

                              ->setCellValue('F'.$g, round($t4['park'],1))

                              ->setCellValue('G'.$g, round($t4['isle'],1))

                              ->setCellValue('H'.$g, round($t4['beckton'],1))

                              ->setCellValue('I'.$g, round($t4['barking'],1))	

                              ->setCellValue('J'.$g, round($t4['leyton'],1))

                              ->setCellValue('K'.$g, round($t4['wstow'],1))

                              ->setCellValue('L'.$g, round($t4['edmonton'],1))

                              ->setCellValue('M'.$g, round($t4['kent'],1))

                              ->setCellValue('N'.$g, round($t4['slough'],1))

                              ->setCellValue('O'.$g, round($t4['cdale'],1))	

                              ->setCellValue('P'.$g, round($t4['peckham'],1))	

                              ->setCellValue('Q'.$g, round($t4['woking'],1))

                              ->setCellValue('R'.$g, round($t4['charlton'],1))

                              ->setCellValue('S'.$g, round($t4['preston'],1))

							  ->setCellValue('T'.$g, round($t4['kanapina'],1))	

                              ->setCellValue('U'.$g, round($t4['total'],1));	

	

							  $g++;						  						  							  							  						

}

$k4=$g;



 $s5 = mysqli_query($con,"select qty ,SUM(if(consid='1',qty,0))AS enfield1 ,SUM(if(consid='2' ,qty,0)) AS hounslow1,SUM(if(consid= '3',qty,0))AS wembley1,SUM(if(consid= '4',qty,0))AS park1,SUM(if(consid= '5',qty,0))AS isle1,SUM(if(consid= '6',qty,0))AS beckton1,SUM(if(consid= '7',qty,0))AS barking1,SUM(if(consid= '8',qty,0))AS leyton1,SUM(if(consid= '9',qty,0))AS wstow1,SUM(if(consid= '10',qty,0))AS edmonton1,SUM(if(consid= '11',qty,0))AS kent1,SUM(if(consid= '12',qty,0))AS slough1,SUM(if(consid= '13',qty,0))AS cdale1,SUM(if(consid= '14',qty,0))AS peckham1,SUM(if(consid= '15',qty,0))AS woking1,SUM(if(consid= '16',qty,0))AS charlton1,SUM(if(consid= '17',qty,0))AS preston1,SUM(if(consid= '18',qty,0))AS kanapina1,SUM(qty)  AS gtotal from tblorder");

$t6 = mysqli_fetch_array($s5);



 $objPHPExcel->getActiveSheet()->setCellValue('A'.$k4,'TOTAL')

                               ->setCellValue('B'.$k4,'')

							   ->setCellValue('C'.$k4,round($t6['enfield1'],1))

							  ->setCellValue('D'.$k4, round($t6['hounslow1'],1))

                              ->setCellValue('E'.$k4, round($t6['wembley1'],1))

                              ->setCellValue('F'.$k4, round($t6['park1'],1))

                              ->setCellValue('G'.$k4, round($t6['isle1'],1))

                              ->setCellValue('H'.$k4, round($t6['beckton1'],1))

                              ->setCellValue('I'.$k4, round($t6['barking1'],1))	

                              ->setCellValue('J'.$k4, round($t6['leyton1'],1))

                              ->setCellValue('K'.$k4, round($t6['wstow1'],1))

                              ->setCellValue('L'.$k4, round($t6['edmonton1'],1))

                              ->setCellValue('M'.$k4, round($t6['kent1'],1))

                              ->setCellValue('N'.$k4, round($t6['slough1'],1))

                              ->setCellValue('O'.$k4, round($t6['cdale1'],1))	

                              ->setCellValue('P'.$k4, round($t6['peckham1'],1))	

                              ->setCellValue('Q'.$k4, round($t6['woking1'],1))

                              ->setCellValue('R'.$k4, round($t6['charlton1'],1))

                              ->setCellValue('S'.$k4, round($t6['preston1'],1))

							  ->setCellValue('T'.$k4, round($t6['kanapina1'],1))	

                              ->setCellValue('U'.$k4, round($t6['gtotal'],1));	

							  

							  							  $x8 = mysqli_query($con,"DROP VIEW tblorder");	

// Rename 2nd sheet

$objPHPExcel->getActiveSheet()->setTitle('Order');



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('HBH CONSOLIDATED REPORT '.$weekdt.' TO '.$dt1.'.xlsx');

?>

<?php

	require_once('../PHPMailer/class.phpmailer.php');



	$mail = new PHPMailer();

	$body = "HBH MEATS CONSOLIDATED REPORT"; 

	 $mail->SetFrom("techsupport@rtnts.co.uk", "HBH");

	$mail->AddReplyTo("techsupport@rtnts.co.uk", "HBH");

	$mail->AddAddress("psdeol@rtnts.co.uk","Param");

    

    $mail->AddAddress("raman@rmaac.co","Raman");

	$mail->Subject = "HBH REPORTS";

	$mail->MsgHTML($body);

	$mail->AddAttachment("HBH CONSOLIDATED REPORT ".$weekdt." TO ".$dt1.".xlsx");

	if(!$mail->Send()) {

	

	} 

else{



	}

	?>      

     