SELECT pmkPlanID, fldDateCreate, fldCatalogYear, fnkStudentNetID, fnkTeacherNetID, pmkYear, pmkTerm, fnkCourseID

FROM tblPlan

JOIN tblSemesterPlan on pmkPlanID = fnkPlanID 
JOIN tblSemesterPlanCourses on tblSemesterPlan.fnkPlanID = tblSemesterPlanCourses.fnkPlanID AND pmkYear = fnkYear AND pmkTerm = fnkTerm

WHERE pmkPlanID = 1

ORDER BY tblSemesterPlan.fldDisplayOrder, tblSemesterPlanCourses.fldDisplayOrder