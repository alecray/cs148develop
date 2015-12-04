CREATE TABLE tblStudents(
	pmkNetID CHAR(20) NOT NULL,
	fldFirstName CHAR(20),
	fldLastName CHAR(20),
	fldYear INTEGER) 
	UNIQUE(pmkNetID);