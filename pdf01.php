<?php
	require('fpdf/mbfpdf.php');
	$pdf = new MbfPDF();
	$pdf -> addpage();
	$pdf -> addMbFont(GOTHIC,'SJIS');
	$pdf -> setFont(GOTHIC,'',10);
	$pdf -> write(10,'���ʉf��\���');
	$con = mysql_connect("localhost","root","");
	mysql_set_charset("utf8");
	mysql_select_db("halcinema",$con);
	$sql = "SELECT count(*) AS kensu,title,reserved_time FROM reserve AS a JOIN movie AS b ON a.movie_id = b.movie_id WHERE ok = 'ok' GROUP BY DATE_FORMAT(a.reserved_time, '%Y%m'),b.movie_id ORDER BY reserved_time DESC";
	$res = mysql_query($sql,$con);
	while($row = mysql_fetch_array($res)){
		$a = mb_convert_encoding($row["kensu"],"SJIS","UTF-8");
		$b = mb_convert_encoding($row["title"],"SJIS","UTF-8");
		$time = date('m',strtotime($row["reserved_time"]));
				$y = $pdf -> getY();
				$pdf -> setXY(10,$y+10);
				$pdf -> write(10,$time."��:".$b.":".$a."�l");
	}
	mysql_close($con);
	$pdf -> output();
?>