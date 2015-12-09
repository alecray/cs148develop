<?php include "top.php"; ?>
<?php
	$columns = 5;
	if(isset($_GET['id'])){
		$pmkJuiceId = $_GET['id'];
	}
	
	$editQuery = 'SELECT fldName, fldLink, fldRating, fldVendor, fldDate
			  FROM tblJuices WHERE pmkJuiceId = ' .$pmkJuiceId;
	$editData = $thisDatabaseReader->select($editQuery, "", 1, 0, 0,0 , false, false);
	foreach($editData as $theData){
		print $theData[0];
		print $theData[1];
		print $theData[2];
		print $theData[3];
		print $theData[4];
	}

?>
<?php include "footer.php";?>