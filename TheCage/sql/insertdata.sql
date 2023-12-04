--Create sports/initialize

INSERT INTO Sport (SportID) VALUES ('Swimming and Diving');
INSERT INTO Sport (SportID) VALUES ('Basketball');
INSERT INTO Sport (SportID) VALUES ('Track & Field');
INSERT INTO Sport (SportID) VALUES ('Football');

--Create athletes/register (did not select sport, coach, or lift group yet)

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70550531, NULL, NULL, 'Lauder', 'Sound', '2038354566', 'soundl9@example.com', 'swimmer123', 'drown123', 'Junior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70550426, NULL, NULL, 'Kason', 'Razor', '2033649121', 'razork8@example.com', 'baller123', 'swish123', 'Junior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70550295, NULL, NULL, 'Tripper', 'John', '2032925594', 'johnt2@example.com', 'runner123', 'sprint123', 'Senior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70550773, NULL, NULL, 'Dirty', 'Dan', '2036662233', 'dand0@example.com', 'dirtyd123', 'footballz', 'Freshman');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70550888, NULL, NULL, 'Smith', 'John', '2031112222', 'johnsmith@example.com', 'swimj123', 'pass123', 'Sophomore');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70550999, NULL, NULL, 'Johnson', 'Emily', '2033334444', 'emilyjohnson@example.com', 'bball_emily', 'password123', 'Junior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass)
VALUES (70551010, NULL, NULL, 'Davis', 'Michael', '2035556666', 'michaeldavis@example.com', 'trackmike', 'securepass', 'Senior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70551111, NULL, NULL, 'Wilson', 'Sarah', '2037778888', 'sarahwilson@example.com', 'football_sarah', 'paz12478', '5+');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70551222, NULL, NULL, 'Brown', 'David', '2039990000', 'davidbrown@example.com', 'swim_david', 'wordd123', 'Freshman');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70551333, NULL, NULL, 'Taylor', 'Olivia', '2031112222', 'oliviataylor@example.com', 'bball_olivia', '123go!', 'Sophomore');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70551444, NULL, NULL, 'Miller', 'Daniel', '2033334444', 'danielmiller@example.com', 'track_daniel', 'runners50', 'Junior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass) 
VALUES (70551555, NULL, NULL, 'Anderson', 'Sophia', '2035556666', 'sophiaanderson@example.com', 'football_sophia', 'boot89l', 'Senior');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass)
VALUES (70559666, NULL, NULL, 'Lee', 'Ethan', '2037778888', 'ethanlee@example.com', 'swim_ethan', 'torpedoE', '5+');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass)
VALUES (70558777, NULL, NULL, 'Harris', 'Ava', '2039990000', 'avaharris@example.com', 'bball_ava', 'aver356', 'Freshman');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass)
VALUES (70554888, NULL, NULL, 'Clark', 'Noah', '2031112222', 'noahclark@example.com', 'track_noah', 'noher345', 'Sophomore');

INSERT INTO Athlete (AthleteID, SportID, LiftGroupID, FirstName, LastName, PhoneNumber, Email, Username, Password, YearClass)
VALUES (70558999, NULL, NULL, 'Lewis', 'Mia', '2033334444', 'mialewis@example.com', 'football_mia', 'miaplanez', 'Junior');


--Create coaches/register (did not select sport yet) 

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (70668903, NULL, 'Tim', 'Quanty', '2347858999', 'timquanty345@example.com', 'tqGod', 't30allday');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (70668223, NULL, 'Chris', 'Morner', '2347858299', 'mornerCH5@example.com', 'cjyurrr', 'haybarn123');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (12345678, NULL, 'Sarah', 'Johnson', '9876543210', 'sarahj@example.com', 'trackstar77', 'runfast12');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (87654321, NULL, 'Michael', 'Davis', '0123456789', 'michaeld@example.com', 'mdtrack19', 'speeddemon22');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (98765432, NULL, 'Rachel', 'Smith', '9876543210', 'rachels@example.com', 'hoopsqueen10', 'baller1234');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (23456789, NULL, 'Mark', 'Wilson', '0123456789', 'markw@example.com', 'mwbasket23', 'bballcoach32');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (34567890, NULL, 'Brandon', 'Taylor', '9876543210', 'brandont@example.com', 'btcoach34', 'touchdown999');

INSERT INTO Coach (CoachID, SportID, FirstName, LastName, PhoneNumber, Email, Username, Password)
VALUES (89012345, NULL, 'Emily', 'Miller', '0123456789', 'emilym@example.com', 'coolemily', 'goblue22');


--Coach picks the sport that they coach 

UPDATE Coach SET SportID = 'Swimming and Diving' WHERE CoachID = 70668903;
UPDATE Coach SET SportID = 'Swimming and Diving' WHERE CoachID = 70668223;

UPDATE Coach SET SportID = 'Basketball' WHERE CoachID = 12345678;
UPDATE Coach SET SportID = 'Basketball' WHERE CoachID = 87654321;

UPDATE Coach SET SportID = 'Track & Field' WHERE CoachID = 98765432;
UPDATE Coach SET SportID = 'Track & Field' WHERE CoachID = 23456789;

UPDATE Coach SET SportID = 'Football' WHERE CoachID = 34567890;
UPDATE Coach SET SportID = 'Football' WHERE CoachID = 89012345;

--Athlete picks the sport that they do 

UPDATE Athlete SET SportID = 'Swimming and Diving' WHERE AthleteID = 70550531;
UPDATE Athlete SET SportID = 'Basketball' WHERE AthleteID = 70550426;
UPDATE Athlete SET SportID = 'Track & Field' WHERE AthleteID = 70550295;
UPDATE Athlete SET SportID = 'Football' WHERE AthleteID = 70550773;

UPDATE Athlete SET SportID = 'Swimming and Diving' WHERE AthleteID = 70550888;
UPDATE Athlete SET SportID = 'Basketball' WHERE AthleteID = 70550999;
UPDATE Athlete SET SportID = 'Track & Field' WHERE AthleteID = 70551010;
UPDATE Athlete SET SportID = 'Football' WHERE AthleteID = 70551111;

UPDATE Athlete SET SportID = 'Swimming and Diving' WHERE AthleteID = 70551222;
UPDATE Athlete SET SportID = 'Basketball' WHERE AthleteID = 70551333;
UPDATE Athlete SET SportID = 'Track & Field' WHERE AthleteID = 70551444;
UPDATE Athlete SET SportID = 'Football' WHERE AthleteID = 70551555;

UPDATE Athlete SET SportID = 'Swimming and Diving' WHERE AthleteID = 70559666;
UPDATE Athlete SET SportID = 'Basketball' WHERE AthleteID = 70558777;
UPDATE Athlete SET SportID = 'Track & Field' WHERE AthleteID = 70554888;
UPDATE Athlete SET SportID = 'Football' WHERE AthleteID = 70558999;


--After picking sport, the athlete chooses who their coaches are to establish a relationship

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (1,70550531,70668903);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (2,70550531,70668223);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (3,70550426,98765432);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (4,70550426,23456789);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (5,70550295,12345678);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (6,70550295,87654321);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (7,70550773,34567890);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (8,70550773,89012345);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (9,70550888,70668903);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (10,70550888,70668223);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (11,70550999,98765432);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (12,70550999,23456789);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (13,70551010,12345678);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (14,70551010,87654321);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (15,70551111,34567890);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (16,70551111,89012345);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (17,70551222,70668903);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (18,70551222,70668223);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (19,70551333,98765432);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (20,70551333,23456789);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (21,70551444,12345678);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (22,70551444,87654321);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (23,70551555,34567890);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (24,70551555,89012345);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (25,70559666,70668903);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (26,70559666,70668223);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (27,70558777,98765432);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (28,70558777,23456789);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (29,70554888,12345678);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (30,70554888,87654321);

INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (31,70558999,34567890);
INSERT INTO AthleteCoach(RelationshipID, AthleteID, CoachID)
Values (32,70558999,89012345);


--ADMIN

INSERT INTO Administrator(Username, Password)
Values ("admin","admin123");

