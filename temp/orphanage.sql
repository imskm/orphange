CREATE TABLE adopter (
	AdopId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	FName VARCHAR(32) NOT NULL,
	LName VARCHAR(32) NOT NULL,
	Gender TINYINT(1) NOT NULL,
	Address1 VARCHAR(100) NOT NULL,
	Address2 VARCHAR(100),
	City VARCHAR(64) NOT NULL,
	Pin CHAR(6) NOT NULL,
	State VARCHAR(64) NOT NULL,
	RegisteredOn Date,
	AdhaarNo VARCHAR(32) NOT NULL,
	Email VARCHAR(64) NOT NULL,
	Phone VARCHAR(12) NOT NULL,
	Photo VARCHAR(255),
	
	PRIMARY KEY(AdopId)
);

CREATE TABLE orphanage (
	OId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	FName VARCHAR(32) NOT NULL,
	LName VARCHAR(32) NOT NULL,
	OrgName VARCHAR(100) NOT NULL,
	Address1 VARCHAR(100) NOT NULL,
	Address2 VARCHAR(100),
	City VARCHAR(64) NOT NULL,
	Pin CHAR(6) NOT NULL,
	State VARCHAR(64) NOT NULL,
	RegNo VARCHAR(32) NOT NULL,
	RegisteredOn Date,
	Email VARCHAR(64) NOT NULL,
	Phone VARCHAR(12) NOT NULL,
	Photo VARCHAR(255),
	
	PRIMARY KEY(OId)
);


CREATE TABLE godchild (
	ChId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	FName VARCHAR(32) NOT NULL,
	LName VARCHAR(32) NOT NULL,
	Dob Date,
	Gender TINYINT(1) NOT NULL,
	Age TINYINT UNSIGNED NOT NULL,
	Colour VARCHAR(32),
	Photo VARCHAR(255),
	
	OId INT UNSIGNED NOT NULL,
	PRIMARY KEY(ChId),
	FOREIGN KEY(OId) REFERENCES orphanage(OId)
);


CREATE TABLE message (
	MsgId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	MsgDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	IsRead TINYINT(1),
	
	AdopId INT UNSIGNED NOT NULL,
	OId INT UNSIGNED NOT NULL,
	PRIMARY KEY(MsgId),
	FOREIGN KEY(AdopId) REFERENCES adopter(AdopId),
	FOREIGN KEY(OId) REFERENCES orphanage(OId)
);


CREATE TABLE appointment (
	AppId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	AppTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	AppCreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Description VARCHAR(255),
	Status TINYINT(1),
	
	AdopId INT UNSIGNED NOT NULL,
	OId INT UNSIGNED NOT NULL,
	PRIMARY KEY(AppId),
	FOREIGN KEY(AdopId) REFERENCES adopter(AdopId),
	FOREIGN KEY(OId) REFERENCES orphanage(OId)
);


CREATE TABLE login (
	LId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Username VARCHAR(255) NOT NULL UNIQUE,
	Password VARCHAR(255) NOT NULL,
	UserId INT UNSIGNED NOT NULL,
	UserType TINYINT(1) NOT NULL,
	
	PRIMARY KEY(Lid)
);


CREATE TABLE report (
	RId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Reporter VARCHAR(64),
	Email VARCHAR(64) NOT NULL,
	Phone VARCHAR(12) NOT NULL,
	ReportedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Location  VARCHAR(100),
	Description VARCHAR(255),

	PRIMARY KEY(RId)
);



CREATE TABLE contact (
	ConId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	Name VARCHAR(64),
	Email VARCHAR(64) NOT NULL,
	Phone VARCHAR(12) NOT NULL,
	ContactedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Message VARCHAR(255),

	PRIMARY KEY(ConId)
);


CREATE TABLE adopt (
	AdoptId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	AdoptedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	
	AdopId INT UNSIGNED NOT NULL,
	OId INT UNSIGNED NOT NULL,
	ChId INT UNSIGNED NOT NULL,
	PRIMARY KEY(AdoptId),
	FOREIGN KEY(AdopId) REFERENCES adopter(AdopId),
	FOREIGN KEY(OId) REFERENCES orphanage(OId),
	FOREIGN KEY(ChId) REFERENCES godchild(ChId)
);



INSERT INTO login(Username, Password, UserId, UserType) VALUES('talaha@gmail.com', '$2y$10$4D8EkZ4o1JGQJa93J/vhPug2m20MfnYWa7TahWWZAYx6Vtak4PAuW', 1, 1);


CREATE TABLE donation (
	DId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	DDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Amount INT UNSIGNED NOT NULL,
	DdNo VARCHAR(32) NOT NULL,
	Msg VARCHAR(255),
	Status TINYINT(1) NOT NULL,
	
	AdopId INT UNSIGNED NOT NULL,
	OId INT UNSIGNED NOT NULL,
	PRIMARY KEY(DId),
	FOREIGN KEY(AdopId) REFERENCES adopter(AdopId),
	FOREIGN KEY(OId) REFERENCES orphanage(OId)
);


--
-- VIEWS
-- Childred View
--
CREATE VIEW children_count_V AS
SELECT OId, count(ChId) Children FROM godchild GROUP BY OId;

-- Male
CREATE VIEW children_male_V AS
SELECT OId, count(Gender) Male FROM godchild WHERE Gender=1 GROUP BY OId;
-- Female
CREATE VIEW children_female_V AS
SELECT OId, count(Gender) Female FROM godchild WHERE Gender=2 GROUP BY OId;

-- Children Stats 
-- PROBLEM : skips record if one of the female or male children v is empty
CREATE VIEW children_stats_V AS
SELECT ch.OId, ch.Children, chm.Male, chf.Female FROM children_count_V ch
	INNER JOIN children_male_V chm ON ch.OId=chm.OId
	INNER JOIN children_female_V chf ON ch.OId=chf.OId
	ORDER BY ch.OId ASC;
-- Improved Children Stats ***
CREATE VIEW children_stats_V AS
SELECT ch.OId, ch.Children, chm.Male, chf.Female FROM children_count_V ch
	LEFT OUTER JOIN children_male_V chm ON ch.OId=chm.OId
	LEFT OUTER JOIN children_female_V chf ON ch.OId=chf.OId
	ORDER BY ch.OId ASC;



-- Orphange details with children stats
CREATE VIEW orphanage_children_V AS
SELECT o.OId, FName, LName, OrgName, Address1, Address2, City, Pin, State, RegNo, RegdOn, Email, Phone, Website, Photo, Children, Male, Female FROM orphanage o
	INNER JOIN children_stats_V chm ON o.OId=chm.OId
	ORDER BY o.OId ASC;
-- Improved Orphange details with children stats
CREATE VIEW orphanage_children_V AS
SELECT o.OId, FName, LName, OrgName, Address1, Address2, City, Pin, State, RegNo, RegdOn, Email, Phone, Website, Photo, Children, Male, Female FROM orphanage o
	LEFT OUTER JOIN children_stats_V chm ON o.OId=chm.OId
	ORDER BY o.OId ASC;


-- Org, Adopter, Child appointment view
-- appoitment_V
CREATE VIEW appointment_V AS
SELECT AppId, AppTimestamp, RequestedOn, Description, Status, app.AdopId, app.OId, app.ChId, o.OrgName, a.FName, a.LName, gc.FName gcFName, gc.LName gcLName  FROM appointment app
	INNER JOIN orphanage o ON o.OId=app.OId
	INNER JOIN adopter a ON a.AdopId=app.AdopId
	INNER JOIN godchild gc ON gc.ChId=app.ChId
	ORDER BY app.AppId ASC;

-- Adopter, Org, Child adoption view
-- appoitment_V
CREATE VIEW adopt_V AS
SELECT a.AdoptId, AdoptedAt, a.AdopId, a.OId, a.ChId, o.OrgName, gc.FName gcFName, gc.LName gcLName  FROM adopt a
	INNER JOIN orphanage o ON o.OId=a.OId
	INNER JOIN adopter ad ON a.AdopId=ad.AdopId
	INNER JOIN godchild gc ON gc.ChId=a.ChId
	ORDER BY a.AdoptId ASC;


CREATE VIEW adopt_child_V
SELECT g.ChId, FName, LName, Dob, Gender, Age, Photo, g.OId, AdoptId FROM godchild g
	LEFT OUTER JOIN adopt a ON a.ChId=g.ChId;


-- Registrations
Orphanage
-------------------
abhiyan_office@sify.com
childrenwalkingtall@hotmail.com
cini@ciniindia.org
princeag@bsnl.in
info@ccchildrenhome.org
barasatanweshan@yahoo.com
clgm1990@yahoo.co.uk






MySQL Cheatsheet
------------------------------------
ALTER TABLE godchild ADD COLUMN RegOn Date AFTER Colour;

-- Upadate multiple columns
UPDATE t1 SET col1 = col1 + 1, col2 = col1;

-- Delete record
DELETE FROM table WHERE colid=3;

-- MySQL dump database (with content and table structure)
mysqldump -u root -p databasename > dump.sql

-- MySQL dump only table structure
-- -d switch is used to dump only table stucture
mysqldump -u root -p -d databasename > dump.sql

-- Dumping MySQL multiple databases
mysqldump -u root -p --databases db1 db2 db3 > dump.sql

-- Renaming a column
ALTER TABLE adopter CHANGE AdhaarNo AadharNo VARCHAR(12);

-- Adding multiple column using ALTER
ALTER TABLE table_name
  ADD column_1 column-definition,
  ADD column_2 column-definition,
      ...
  ADD column_n column_definition;





console.log(document.getElementById('rqappointment').nextElementSibling.value)











