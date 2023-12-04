-- Athlete Table
CREATE TABLE Athlete (
    AthleteID int PRIMARY KEY,
	SportID varchar(50) NULL,
	LiftGroupID int NULL,
	FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    PhoneNumber varchar(11) NOT NULL,
    Email varchar(50) NOT NULL,
	ClassYear varchar(50) NOT NULL,
    Username varchar(50) NOT NULL,
    Password varchar(50) NOT NULL
);

CREATE TABLE Administrator (
    Username varchar(50) Primary KEY,
    Password varchar(50) NOT NULL
);

-- Coach Table
CREATE TABLE Coach (
    CoachID int PRIMARY KEY,
    SportID varchar(50) NULL,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    PhoneNumber varchar(11) NOT NULL,
    Email varchar(50) NOT NULL,
    Username varchar(50) NOT NULL,
    Password varchar(50) NOT NULL
);

-- AthleteCoach Relationship Table
CREATE TABLE AthleteCoach (
    RelationshipID int PRIMARY KEY,
    AthleteID int NOT NULL,
    CoachID int NOT NULL
);

-- Sport Table
CREATE TABLE Sport (
    SportID varchar(50) PRIMARY KEY
);



-- LiftGroup Table
CREATE TABLE LiftGroup (
    LiftGroupID int ,
    SportID varchar(50) NOT NULL
);

-- Workout Table
CREATE TABLE Workout (
    WorkoutID int ,
    SportID varchar(50) NOT NULL,
    Name varchar(50) NOT NULL,
    NumberOfWeeks int NOT NULL
);

-- Exercise Table
CREATE TABLE Exercise (
    ExerciseID varchar(50) ,
    WorkoutID int NOT NULL,
    Name varchar(50) NOT NULL,
    NumberSets int NOT NULL,
    NumberReps int NOT NULL,
    NotesTempoPercentage varchar(MAX)
);

-- Session Table
CREATE TABLE WorkoutSession (
    SessionID varchar(50) ,
    AthleteID int NOT NULL,
    WorkoutID int NOT NULL,
    Completion Boolean NOT NULL,
    EarlyClass Boolean NOT NULL,
    Soreness int NOT NULL,
    Difficulty int NOT NULL,
    SessionNotes varchar(MAX)
);

-- Goal Table
CREATE TABLE Goal (
    GoalID int ,
    AthleteID int NOT NULL,
    ExerciseID int NOT NULL,
    GoalReached Boolean NOT NULL,
    GoalNotes varchar(MAX)
);

-- Event Table
CREATE TABLE Event (
    EventID varchar(50) ,
    EventName varchar(255) NOT NULL,
    Date DATE NOT NULL
);

-- Attempt Table
CREATE TABLE Attempt (
    AttemptID int ,
    AthleteID int NOT NULL,
    EventID int NOT NULL
);

-- Leaderboard Table
CREATE TABLE Leaderboard (
    LeaderboardID varchar(50) ,
    AttemptID int NOT NULL
);


--Foreign Key Constraints
--******Remember that the FOREIGN KEY clause must be specified in the child table.******


--Athlete
--******ALTER TABLE Athlete ADD CONSTRAINT FK_AthleteSport FOREIGN KEY (SportID) REFERENCES Sport(SportID);
ALTER TABLE Athlete ADD CONSTRAINT FK_AthleteSport FOREIGN KEY (SportID) REFERENCES Sport(SportID);


--Coach 
--******ALTER TABLE Coach ADD CONSTRAINT FK_CoachSport FOREIGN KEY (SportID) REFERENCES Sport(SportID);


--AthleteCoach
ALTER TABLE AthleteCoach ADD CONSTRAINT FK_AthleteRelationship FOREIGN KEY (AthleteID) REFERENCES Athlete(AthleteID);
ALTER TABLE AthleteCoach ADD CONSTRAINT FK_CoachRelationship FOREIGN KEY (CoachID) REFERENCES Coach(CoachID);



