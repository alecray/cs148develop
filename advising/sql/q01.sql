SELECT pmkPlanID, fldDateCreate, fldCatalogYear, fnkStudentNetID, fnkTeacherNetID, pmkYear, pmkTerm, fnkCourseID, pmkCourseId, fldDepartment, fldCredits, fldCourseNumber

FROM tblPlan 

JOIN tblSemesterPlan on pmkPlanID = fnkPlanID 
JOIN tblSemesterPlanCourses on tblSemesterPlan.fnkPlanID = tblSemesterPlanCourses.fnkPlanID AND pmkYear = fnkYear AND pmkTerm = fnkTerm 
JOIN tblCourses on tblSemesterPlanCourses.fnkCourseID = tblCourses.pmkCourseId

WHERE pmkPlanID = 1 

ORDER BY tblSemesterPlan.fldDisplayOrder, tblSemesterPlanCourses.fldDisplayOrder