-- Athlete Table
CREATE TABLE Athlete (
    AthleteID int PRIMARY KEY,
	SportID varchar(50) NOT NULL,
	LiftGroupID int NULL,
	FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    PhoneNumber varchar(11) NOT NULL,
    Email varchar(50) NOT NULL,
	ClassYear varchar(50) NOT NULL,
    Username varchar(50) NOT NULL,
    Password varchar(50) NOT NULL,
	Height varchar(20) NULL,
	Weight varchar(10) NULL,
	Major varchar(30) NULL,
	EventsOrPosition varchar(100) NULL,
	FavoriteFood varchar(50) NULL,
	FavoriteMusicArtist varchar(50) NULL,
	Hobbies varchar(200) NULL
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
    LiftGroupID INT AUTO_INCREMENT PRIMARY KEY,
    SportID VARCHAR(50) NOT NULL
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

CREATE TABLE WorkoutExercise (
    WorkoutID INT,
    ExerciseID INT
);

-- Session Table
CREATE TABLE WorkoutSession (
    SessionID INT AUTO_INCREMENT PRIMARY KEY,
    AthleteID int NOT NULL,
    WorkoutID int NOT NULL,
    Completion Boolean NOT NULL,
    EarlyClass Boolean NOT NULL,
    Soreness int NOT NULL,
    Difficulty int NOT NULL,
    SessionNotes varchar(255)
);

-- Goal Table
CREATE TABLE Goal (
    GoalID int ,
    AthleteID int NOT NULL,
    ExerciseID int NULL,
    GoalReached Boolean NOT NULL,
    GoalNotes varchar(MAX)
);

-- Event Table
-- Create Event Table
CREATE TABLE Event (
    EventID INT AUTO_INCREMENT PRIMARY KEY,
    EventName VARCHAR(255) NOT NULL,
    Date DATE NOT NULL
);


-- Create Attempt Table
CREATE TABLE Attempt (
    AttemptID INT AUTO_INCREMENT PRIMARY KEY,
    AthleteID INT NOT NULL,
    EventID INT NOT NULL,
    RecordInput VARCHAR(255),
    Verified BOOLEAN
);

-- Create Leaderboard Table
CREATE TABLE Leaderboard (
    LeaderboardID INT AUTO_INCREMENT PRIMARY KEY,
    EventID INT NOT NULL
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



