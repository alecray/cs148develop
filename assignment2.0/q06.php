<?php

//##############################################################################
//
// This page lists your tables and fields within your database. if you click on
// a database name it will show you all the records for that table. 
// 
// 
// This file is only for class purposes and should never be publicly live
//##############################################################################
include "top.php";
	$columns = 2;
	
	print '<table>';
	$query = file_get_contents('sql/q06.sql');
	//$testquery = $thisDatabaseReader->testquery($query, "", 0, 0, 0,0 , false, false);
	print $query;
	print '<br>';
	$info2 = $thisDatabaseReader->select($query, "", 0, 2, 4,0 , false, false);
	$numRecords = count($info2);
    $highlight = 0; // used to highlight alternate rows
	print '<br>';
	
	print '<strong>Records: ' . $numRecords . '</strong>';
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