<?php
include "top.php";
	$columns = 8;
	$lowerLimit = (int) $_GET['lowerLimit'];
	$upperLimit = (int) $_GET['upperLimit'];
	print '<table>';
	$query = "SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName LIMIT " . $lowerLimit . ", " . $upperLimit;
	//$testquery = $thisDatabaseReader->testquery($query, "", 0, 1, 0,0 , false, false);
	print $query;
	print '<br>';
	$info2 = $thisDatabaseReader->select($query, "", 0, 1, 0,0 , false, false);
	$fields = array_keys($info2[0]);
	$labels = array_filter($fields, "is_string");
	$numRecords = count($info2);
    $highlight = 0; // used to highlight alternate rows
	print '<br>';
	
	print '<strong>Records: ' . $numRecords . '</strong>';
	foreach ($labels as $label) {
		$camelCase = preg_split('/(?=[A-Z])_/', substr($label, 3));
			$message = '';
		foreach ($camelCase as $one) {
			$message .= $one . " ";
		}
		print '<th>' . $message . '</th>';
	}
    foreach ($info2 as $rec) {
        $highlight++;
        if ($highlight % 2 != 0) {
            $style = ' odd ';
        } else {
            $style = ' even ';
        }
        print '<tr class="' . $style . '">';
        for ($i = 0; $i < $columns; $i++) {
            print '<td>' . $rec[$i] . '</td>';
        }
        print '</tr>';
    }

    // all done
    print '</table>';
include "footer.php";
?>