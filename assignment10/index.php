<?php include "top.php"; ?>
<?php
// Begin output
print '<article>';
$columns = 6;
	$num = 10;
	$start = 0;	
	if(isset($_GET['num'])){
		$num = $_GET['num'];
	}
	if(isset($_GET['start'])){
		$start = $_GET['start'];
	}
	print '<br>';
	print '<br>';
	print '<table class="juiceList">';
	$query = "SELECT pmkJuiceId, fldName, fldLink, fldRating, fldVendor, fldDate, fldTag
			  FROM tblJuices  
			  JOIN tblJuicesTags ON tblJuicesTags.fnkJuiceId = tblJuices.pmkJuiceId
			  JOIN tblTags ON tblTags.pmkTagId = tblJuicesTags.fnkTagId
			  GROUP BY fldName
			  ORDER BY fldRating DESC 
			  LIMIT " . $num . " OFFSET " . $start;
	$query2 = "SELECT fldName, fldLink, fldRating, fldVendor, fldDate 
			   FROM tblJuices 
			   ORDER BY fldRating DESC";
	//$testquery = $thisDatabaseReader->testquery($query, "", 0, 1, 0,0 , false, false);
	//print $query;
	
	$info2 = $thisDatabaseReader->select($query, "", 0, 1, 0,0 , false, false);
	$totalQuery = $thisDatabaseReader->select($query2, "", 0, 1, 0,0 , false, false);
	$fields = array_keys($info2[0]);
	$labels = array_filter($fields, "is_string");
	$numRecords = count($info2);
	$totalNum = count($totalQuery);
    $highlight = 0; // used to highlight alternate rows
	
	foreach ($labels as $label) {
		$camelCase = preg_split('/(?=[A-Z])_/', substr($label, 3));
			$message = '';
		foreach ($camelCase as $one) {
			$message .= $one . " ";
		}
		if ($message == "Link " or $message == "JuiceId "){
			print '';
		}
		else {
			print '<th>' . $message . '</th>';
		}
	}
	print '<tr class="separator" />';
    foreach ($info2 as $rec) {
        $highlight++;
        if ($highlight % 2 != 0) {
            $style = ' odd ';
        } else {
            $style = ' even ';
        }
        print '<tr class="' . $style . '">';
        for ($i = 0; $i < $columns; $i++) {
			if($i == 0){
				print '';
			}
			if($i == 1){
				print '<td><a href="http://' . $rec[2] . '" target="_blank">' . $rec[1] . '</td>';
				$i=3;
			}
			
			if($i == 3){
				print '<td>';
				for ($s = 0; $s < $rec[$i]; $s++){
					print '<img src="images/star.png" width="20px">';
				}
				print '</td>';
				$i = 4;
			}
			if($i == 5){
				print '<td>';
				$datePieces = explode(" ", $rec[$i]);
				$rec[$i] = $datePieces[0];
				print $rec[$i] . '</td>';
				$i = 6;
			}
			if($i == 6 or $i == 4){
				print '<td>' . $rec[$i] . '</td>';
				
			}
			if($admin == 1 and $i > 5){
				print '<td style="padding-right: 0px;min-width: 50px;"><a href="addJuiceForm.php?id='.$rec[0].'">[ Edit ]</a></td>';
			}
        }
        print '</tr>';
		print '<tr class="separator" />';
    }

    // all done
    print '</table>';
	print '<section class="buttons">';
	$increment = 10;
	if($start<=0){
		print '<button>Previous</button>';
	}	
	else { 
		print '<a href="index.php?num=10&start='. ($start - $increment) .'"><button>Previous</button></a>';
	}
	if ($start>=$totalNum-10){
		print '<button>Next</button>';
	}
	else {
		print '<a href="index.php?num=10&start='. ($start + $increment) .'"><button>Next</button></a>';
	}
	print '<br>';
	print '<p class="entries">' . $start . ' - ' . ($start+$num) . ' Entries</p>';
	print '</section>';
print '</article>';

include "footer.php";
?>