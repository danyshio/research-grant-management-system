-- Create database --
CREATE DATABASE IF NOT EXISTS research_grant_db;
USE research_grant_db;

CREATE TABLE user (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Researcher','Reviewer','HOD','Admin') NOT NULL,
    status ENUM('Active','Inactive') NOT NULL
);

CREATE TABLE proposal (
    proposalId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    abstract TEXT NOT NULL,
    submissionDate DATE NOT NULL,
    status ENUM('Submitted','Pending','Reviewed','Approved','Rejected') NOT NULL,
    FOREIGN KEY (userId) REFERENCES user(userId)
);

CREATE TABLE review (
    reviewId INT AUTO_INCREMENT PRIMARY KEY,
    proposalId INT NOT NULL,
    decision ENUM('Approve','Reject','Request Changes') NOT NULL,
    comments TEXT NOT NULL,
    reviewDate DATE NOT NULL,
    FOREIGN KEY (proposalId) REFERENCES proposal(proposalId)
);

CREATE TABLE feedback (
    feedbackId INT AUTO_INCREMENT PRIMARY KEY,
    proposalId INT NOT NULL,
    content TEXT NOT NULL,
    feedbackDate DATE NOT NULL,
    FOREIGN KEY (proposalId) REFERENCES proposal(proposalId)
);

CREATE TABLE grant_funding (
    grantId INT AUTO_INCREMENT PRIMARY KEY,
    proposalId INT NOT NULL,
    amount DOUBLE NOT NULL,
    allocationDate DATE NOT NULL,
    FOREIGN KEY (proposalId) REFERENCES proposal(proposalId)
);

CREATE TABLE budget (
    budgetId INT AUTO_INCREMENT PRIMARY KEY,
    proposalId INT NOT NULL,
    item VARCHAR(200) NOT NULL,
    cost DOUBLE NOT NULL,
    FOREIGN KEY (proposalId) REFERENCES proposal(proposalId)
);

CREATE TABLE progress_report (
    reportId INT AUTO_INCREMENT PRIMARY KEY,
    proposalId INT NOT NULL,
    submissionDate DATE NOT NULL,
    status ENUM('Submitted','Reviewed') NOT NULL,
    comments TEXT,
    FOREIGN KEY (proposalId) REFERENCES proposal(proposalId)
);

CREATE TABLE document (
    documentId INT AUTO_INCREMENT PRIMARY KEY,
    proposalId INT NOT NULL,
    submissionDate DATE NOT NULL,
    status ENUM('Uploaded','Reviewed') NOT NULL,
    comments TEXT,
    FOREIGN KEY (proposalId) REFERENCES proposal(proposalId)
);

CREATE TABLE notification (
    notificationId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT NOT NULL,
    message TEXT NOT NULL,
    dateTime DATETIME NOT NULL,
    status ENUM('Read','Unread') NOT NULL,
    FOREIGN KEY (userId) REFERENCES user(userId)
);

