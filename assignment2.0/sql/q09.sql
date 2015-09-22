SELECT DISTINCT fldBuilding, fldNumStudents
FROM tblSections
WHERE fldDays LIKE "%W%"
GROUP by fldBuilding
ORDER BY fldNumStudents DESC

