-- USERS
INSERT INTO user (name, email, password, role, status) VALUES
('Iliya Researcher', 'iliya@uni.edu', '12345', 'Researcher', 'Active'),
('Dr Danysh Reviewer', 'danysh@uni.edu', '12345', 'Reviewer', 'Active'),
('Prof Thash HOD', 'tan@uni.edu', '12345', 'HOD', 'Active'),
('Admin Mustafa', 'admin@uni.edu', '12345', 'Admin', 'Active');

-- PROPOSAL
INSERT INTO proposal (userId, title, abstract, submissionDate, status) VALUES
(1, 'AI-Based Flood Prediction System',
 'This research proposes an AI-based system to predict floods using real-time data.',
 CURDATE(), 'Submitted');

-- REVIEW
INSERT INTO review (proposalId, decision, comments, reviewDate) VALUES
(1, 'Approve', 'The proposal is well-structured and feasible.', CURDATE());

-- FEEDBACK
INSERT INTO feedback (proposalId, content, feedbackDate) VALUES
(1, 'Minor improvements required in methodology section.', CURDATE());

-- GRANT
INSERT INTO grant_funding (proposalId, amount, allocationDate) VALUES
(1, 50000.00, CURDATE());

-- BUDGET
INSERT INTO budget (proposalId, item, cost) VALUES
(1, 'Equipment Purchase', 20000.00),
(1, 'Research Assistant Salary', 30000.00);

-- PROGRESS REPORT
INSERT INTO progress_report (proposalId, submissionDate, status, comments) VALUES
(1, CURDATE(), 'Submitted', 'Initial progress completed.');

-- DOCUMENT
INSERT INTO document (proposalId, submissionDate, status, comments) VALUES
(1, CURDATE(), 'Uploaded', 'Proposal document uploaded.');

-- NOTIFICATION
INSERT INTO notification (userId, message, dateTime, status) VALUES
(1, 'Your proposal has been submitted successfully.', NOW(), 'Unread');
