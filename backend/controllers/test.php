<?php
insert into admresults 
studid, cert, institution,certno,indexno,certclass,subject,grade
while ($line = fgetcsv($file)){
	$numcols = count($line);
}


$csv_headings = fgetcsv($handle, 4096, ",");
$flag = true;
while (($fileop = fgetcsv($handle, 4096, ",")) !== false) 
                         {	
                         	if ($flag) {
                         		$flag = false;
                         		continue;
                         	}
                         	$numcols = count($fileop);
                         	$numcols1 = 6;
                         	while ($numcols1 < $numcols) {
	                            $studid = $fileop[0];
	                            $cert = $fileop[1];
	                            $institution = $fileop[2];
	                            $certno = $fileop[3];
	                            $indexno = $fileop[4];
	                            $certclass = $fileop[5]; // certclass ... recurrent data begins after
	                            // ENGLISH LANGUAGE	MATHEMATICS	INTEGRATED SCIENCE	SOCIAL STUDIES	PHYSICS	CHEMISTRY	BIOLOGY	ELECTIVE MATHEMATICS	GENERAL AGRICULTURE	CROP HUSBANDRY	ANIMAL HUSBANDRY	fisheries
	                            $subject = $csv_headings[$numcols1];
	                            $grade = $fileop[$numcols1];
	                            // print_r($fileop);exit();
	                         	$sql = "INSERT INTO admissionresult(studid, cert, institution,certno,indexno,certclass,subject,grade) VALUES ('$studid', '$cert', '$institution', '$certno','$indexno','$certclass','$subject','$grade')";
	                            $query = Yii::$app->db->createCommand($sql)->execute();
                            }
                            
                         }
// ===========================================================================================
$result = mysql_query("SELECT DISTINCT column_name FROM information_schema.columns WHERE table_name = 'admdt' ORDER BY ordinal_position");
if (!$result){
	echo "Could not run query:".mysql_error();
	exit;
}
$mysql_row = mysql_fetch_row($result);
// echo $mysql_row[0];                       
$csv_head_row = fgetcsv($handle, 4096, ",");
$numcols = count($csv_head_row);
$col_no = 6;
while ($col_no < $numcols) {
	$col_title_split = split(' ', $csv_head_row[$col_no]);
	$col_title = $col_title_split[0].'_'.$col_title_split[1];
	if ($col_title == $mysql_row[$col_no]) {
		# increment the value of $col_no by 1 and continue
		$col_no = $col_no +1;
		continue;
	} else {
		# Modify table admdt. Add column $csv_head_row[$col_no]
		$sql_alter = mysql_query("ALTER TABLE `admdt` ADD `$col_title` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-' COMMENT '$csv_head_row[$col_no]' AFTER `$mysql_row[$col_no]`");		
		if (!$sql_alter){
			echo "Could not run query:".mysql_error();
			exit;
		}
		$col_no = $col_no +1;
	}
}

// ===========================================================================================
"ALTER TABLE `admdt` CHANGE `GENERAL_AGRICULTURE` `GENERAL_AGRICULTURE` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '-' COMMENT 'GENERAL AGRICULTURE';"
$sql = "desc admdt";
$sql = "SHOW FIELDS FROM admdt";
$sql = "select column_name from information_schema.columns where table_name='admdt'";
$sql = "select column_name from information_schema.columns where table_name='admdt' order by ordinal_position";
$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = 'admdt'";
$sql = "SELECT DISTINCT column_name FROM information_schema.columns WHERE table_schema ='arms-demo' and table_name = 'admdt'";
$sql = "SELECT DISTINCT column_name FROM information_schema.columns WHERE table_name = 'admdt'";
$sql = "SELECT DISTINCT column_name FROM information_schema.columns WHERE table_name = 'admdt' ORDER BY ordinal_position";
// jump_cut clipboard, my alltop, food.alltop, smartbrief, tedtalks on Youtube, buffer social media schedule chrome extension, Do share for Google+, Nuke Comments, Guy Kawasaki
// The slingshot channel on youtube
?>