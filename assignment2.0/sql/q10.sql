SELECT DISTINCT fldBuilding, fldNumStudents
FROM tblSections
WHERE fldDays LIKE "%F%"
GROUP by fldBuilding
ORDER BY fldNumStudents DESC

