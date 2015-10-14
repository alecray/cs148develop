SELECT DISTINCT fldDays, fldStart 
FROM tblSections, tblTeachers
WHERE tblTeachers.fldLastName = "Snapp" AND tblTeachers.fldFirstName = "Robert Raymond" AND tblTeachers.pmkNetId = tblSections.fnkTeacherNetId
GROUP BY fldStart