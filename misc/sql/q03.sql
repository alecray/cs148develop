SELECT DISTINCT fldCourseName, tblSections.fldDays, tblSections.fldStart 
FROM tblSections 
INNER JOIN tblCourses on pmkCourseId = tblSections.fnkCourseId 
INNER JOIN tblTeachers on pmkNetId = fnkTeacherNetId 
WHERE tblTeachers.fldLastName = "Horton"
GROUP BY tblSections.fldStart