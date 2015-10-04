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
<p><a href="q01.php">Query 1</a> - Display all the distinct course names (sorted of course) for courses which had a student receive a grade of 100. (13)</p>
<p><a href="q02.php">Query 2</a> - Display the distinct days of the week and times (sorted by times) during which Robert Snap (where clause should not contain his netid but his full name) teaches classes. (3)</p>
<p><a href="q03.php">Query 3</a> - Display the distinct course names, days of the week and times (sorted by times) of classes taught by Jackie Horton. (4)</p>
<p><a href="q04.php">Query 4</a> - Display the crn, first and last names (sorted crn, last name, first name) of all students taking CS 148 (78)</p>
<p><a href="q05.php">Query 5</a> - Display First Name, Last Name and total number of students taught by each professor (with the field name aliased as 'total'). NOTE: think why some professors have SO many students when you run your query.</p>
<p><a href="q06.php">Query 6</a> - Display the first name, phone number, and salary of all teachers who earn less than average salary (514)</p>
</section>
<?php
include "footer.php";
?>