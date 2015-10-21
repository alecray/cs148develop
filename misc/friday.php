<?php
include "top.php";
	$columns = 8;
	$num = 10;
	$start = 0;
	if(isset($_GET['num'])){
		$num = $_GET['num'];
	}
	if(isset($_GET['start'])){
		$start = $_GET['start'];
	}
	print '<table>';
	$query = "SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName LIMIT " . $num . " OFFSET " . $start;
	$query2 = "SELECT * FROM tblStudents ORDER BY fldLastName, fldFirstName";
	//$testquery = $thisDatabaseReader->testquery($query, "", 0, 1, 0,0 , false, false);
	print $query;
	print '<br>';
	$info2 = $thisDatabaseReader->select($query, "", 0, 1, 0,0 , false, false);
	$totalQuery = $thisDatabaseReader->select($query2, "", 0, 1, 0,0 , false, false);
	$fields = array_keys($info2[0]);
	$labels = array_filter($fields, "is_string");
	$numRecords = count($info2);
	$totalNum = count($totalQuery);
    $highlight = 0; // used to highlight alternate rows
	print '<br>';
	
	print '<strong>Records: ' . $start . ' - ' . ($start+$num) . '</strong>';
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
	$increment = 10;
	if($start<=0){
		print '<button>Previous</button>';
	}	
	else { 
		print '<a href="friday.php?num=10&start='. ($start - $increment) .'"><button>Previous</button></a>';
	}
	if ($start>=$totalNum-10){
		print '<button>Next</button>';
	}
	else {
		print '<a href="friday.php?num=10&start='. ($start + $increment) .'"><button>Next</button></a>';
	}
include "footer.php";
?>