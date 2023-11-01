-- Athlete Table
CREATE TABLE Athlete (
    AthleteID int PRIMARY KEY,
    SportID varchar(50),
    LftGroupID int,
    RelationshipID int,
    FirstName varchar(50),
    LastName varchar(50),
    PhoneNumber varchar(11),
    Email varchar(50),
    Username varchar(50),
    Password varchar(50),
    Class varchar(50)
);

-- Coach Table
CREATE TABLE Coach (
    CoachID int PRIMARY KEY,
    SportID varchar(50),
    FirstName varchar(50),
    LastName varchar(50),
    PhoneNumber varchar(11),
    Email varchar(50),
    Username varchar(50),
    Password varchar(50)
);

-- AthleteCoach Relationship Table
CREATE TABLE AthleteCoach (
    RelationshipID int PRIMARY KEY,
    AthleteID int,
    CoachID int
);

-- Sport Table
CREATE TABLE Sport (
    SportID varchar(50) PRIMARY KEY,
    AthleteID int,
    Name varchar(50)
);

-- LiftGroup Table
CREATE TABLE LiftGroup (
    LftGroupID int PRIMARY KEY,
    SportID varchar(50)
);

-- Workout Table
CREATE TABLE Workout (
    WorkoutID int PRIMARY KEY,
    SportID varchar(50),
    Name varchar(50),
    NumberOfWeeks int
);

-- Exercise Table
CREATE TABLE Exercise (
    ExerciseID varchar(50) PRIMARY KEY,
    WorkoutID int,
    Name varchar(50),
    Sets int,
    Reps int,
    NotesTempoPercentage varchar(MAX)
);

-- Session Table
CREATE TABLE Session (
    SessionID varchar(50) PRIMARY KEY,
    AthleteID int,
    WorkoutID int,
    Completion Boolean,
    810Class Boolean,
    Soreness int,
    Difficulty int,
    Notes varchar(MAX)
);

-- Goal Table
CREATE TABLE Goal (
    GoalID int PRIMARY KEY,
    AthleteID int,
    ExerciseID int,
    GoalReached Boolean,
    GoalNotes varchar(MAX)
);

-- Event Table
CREATE TABLE Event (
    EventID varchar(50) PRIMARY KEY,
    EventName varchar(MAX),
    Date DATE
);

-- Attempt Table
CREATE TABLE Attempt (
    AttemptID int PRIMARY KEY,
    AthleteID int,
    EventID int
);

-- Leaderboard Table
CREATE TABLE Leaderboard (
    LeaderboardID varchar(50) PRIMARY KEY,
    AttemptID int
);
