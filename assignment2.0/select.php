<?php

//##############################################################################
//
// This page lists your tables and fields within your database. if you click on
// a database name it will show you all the records for that table. 
// 
// 
// This file is only for class purposes and should never be publicly live
//##############################################################################
include "top.php";?>
<section class="mainSection">
<p><a href="q01.php">Query 1</a> - Display just the NetID of all teachers. (1010)</p>
<p><a href="q02.php">Query 2</a> - Display just the department for courses named "Introduction" (12)</p>
<p><a href="q03.php">Query 3</a> - Display all section data for classes that start at 1:10PM in Kalkin (10)</p>
<p><a href="q04.php">Query 4</a> - Display all course data for our class (1)</p>
<p><a href="q05.php">Query 5</a> - Display the first and last name of teachers whose Net ID begins with the letter 'r' and ends in the letter "o". (4)</p>
<p><a href="q06.php">Query 6</a> - Display every course name with the word "data" in it that is not in the CS department (7)</p>
<p><a href="q07.php">Query 7</a> - Display the number of distinct departments (133)</p>
<p><a href="q08.php">Query 8</a> - Display each building name and the number of sections it has (59)</p>
<p><a href="q09.php">Query 9</a> - Display each building name and the number of students in it on Wednesday, sorted by the number of students descending (51)</p>
<p><a href="q10.php">Query 10</a> - Repeat the above query for Friday (44) - Compare the Kalkin building for Wednesday and Friday. How would you verify the results and explain why?</p>
</section>
<?php
include "footer.php";
?>