SELECT fldCRN, fldFirstName, fldLastName, tblEnrolls.fnkCourseId
FROM tblStudents
INNER JOIN tblEnrolls on pmkStudentId = tblEnrolls.fnkStudentId
INNER JOIN tblSections on tblEnrolls.fnkCourseId = tblSections.fnkCourseId
WHERE tblEnrolls.fnkCourseId = 392
GROUP BY fldFirstName
