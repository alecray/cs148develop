SELECT fnkCourseId,fldCRN,fnkTeacherNetId,fldMaxStudents,fldNumStudents,fldSection,fldType,fldStart,fldStop,fldDays,fldBuilding,fldRoom
FROM tblSections 
WHERE fldBuilding LIKE 'KALKIN%' AND fldStart = "13:10:00"
