-- Athlete Table
CREATE TABLE Athlete (
    AthleteID int PRIMARY KEY,
    SportID varchar(50) NOT NULL,
    LiftGroupID int NOT NULL,
    RelationshipID int,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    PhoneNumber varchar(50) NOT NULL,
    Email varchar(50) NOT NULL,
    Username varchar(50) NOT NULL,
    Password varchar(50) NOT NULL,
    Class varchar(50) NOT NULL,
    FOREIGN KEY (SportID) REFERENCES Sport(SportID),
    FOREIGN KEY (LiftGroupID) REFERENCES LiftGroup(LiftGroupID),
    FOREIGN KEY (RelationshipID) REFERENCES AthleteCoach(RelationshipID)
);

-- Coach Table
CREATE TABLE Coach (
    CoachID int PRIMARY KEY,
    SportID varchar(50) NOT NULL,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50) NOT NULL,
    PhoneNumber varchar(50) NOT NULL,
    Email varchar(50) NOT NULL,
    Username varchar(50) NOT NULL,
    Password varchar(50) NOT NULL,
    FOREIGN KEY (SportID) REFERENCES Sport(SportID)
);

-- AthleteCoach Relationship Table
CREATE TABLE AthleteCoach (
    RelationshipID int PRIMARY KEY,
    AthleteID int NOT NULL,
    CoachID int NOT NULL,
    FOREIGN KEY (AthleteID) REFERENCES Athlete(AthleteID),
    FOREIGN KEY (CoachID) REFERENCES Coach(CoachID)
);

-- Sport Table
CREATE TABLE Sport (
    SportID varchar(50) PRIMARY KEY,
    Name varchar(50) NOT NULL
);

-- LiftGroup Table
CREATE TABLE LiftGroup (
    LiftGroupID int PRIMARY KEY,
    SportID varchar(50) NOT NULL,
    FOREIGN KEY (SportID) REFERENCES Sport(SportID)
);

-- Workout Table
CREATE TABLE Workout (
    WorkoutID int PRIMARY KEY,
    SportID varchar(50) NOT NULL,
    Name varchar(50) NOT NULL,
    NumberOfWeeks int NOT NULL,
    FOREIGN KEY (SportID) REFERENCES Sport(SportID)
);

-- Exercise Table
CREATE TABLE Exercise (
    ExerciseID int PRIMARY KEY,
    WorkoutID int NOT NULL,
    Name varchar(50) NOT NULL,
    Sets int NOT NULL,
    Reps int NOT NULL,
    NotesTempoPercentage varchar(MAX),
    FOREIGN KEY (WorkoutID) REFERENCES Workout(WorkoutID)
);

-- Session Table
CREATE TABLE Session (
    SessionID int PRIMARY KEY,
    AthleteID int NOT NULL,
    WorkoutID int NOT NULL,
    Completion BOOLEAN NOT NULL,
    EarlyClass BOOLEAN NOT NULL,
    Soreness int NOT NULL,
    Difficulty int NOT NULL,
    Notes varchar(MAX),
    FOREIGN KEY (AthleteID) REFERENCES Athlete(AthleteID),
    FOREIGN KEY (WorkoutID) REFERENCES Workout(WorkoutID)
);

-- Goal Table
CREATE TABLE Goal (
    GoalID int PRIMARY KEY,
    AthleteID int NOT NULL,
    ExerciseID int NOT NULL,
    GoalReached BOOLEAN NOT NULL,
    GoalNotes varchar(MAX),
    FOREIGN KEY (AthleteID) REFERENCES Athlete(AthleteID),
    FOREIGN KEY (ExerciseID) REFERENCES Exercise(ExerciseID)
);

-- Event Table
CREATE TABLE Event (
    EventID int PRIMARY KEY,
    EventName varchar(255) NOT NULL,
    Date DATE NOT NULL
);

-- Attempt Table
CREATE TABLE Attempt (
    AttemptID int PRIMARY KEY,
    AthleteID int NOT NULL,
    EventID int NOT NULL,
    FOREIGN KEY (AthleteID) REFERENCES Athlete(AthleteID),
    FOREIGN KEY (EventID) REFERENCES Event(EventID)
);

-- Leaderboard Table
CREATE TABLE Leaderboard (
    LeaderboardID int PRIMARY KEY,
    AttemptID int NOT NULL,
    FOREIGN KEY (AttemptID) REFERENCES Attempt(AttemptID)
);
