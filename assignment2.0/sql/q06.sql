SELECT fldCourseName, fldDepartment
FROM tblCourses
WHERE fldCourseName LIKE "%data%" AND fldDepartment != "CS"