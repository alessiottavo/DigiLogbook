CREATE DATABASE IF NOT EXISTS digilog_db;

USE digilog_db;

CREATE TABLE IF NOT EXISTS pilots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pilot_name VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    student BOOLEAN NOT NULL,
    ppl TIMESTAMP,
    cpl TIMESTAMP,
    atpl TIMESTAMP,
    hp BOOLEAN NOT NULL,
    complex BOOLEAN NOT NULL,
    gear BOOLEAN NOT NULL,
    tail BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS aircrafts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(100) NOT NULL,
    registration VARCHAR(100) NOT NULL,
    high_performance BOOLEAN NOT NULL,
    taildragger BOOLEAN NOT NULL,
    complex BOOLEAN NOT NULL,
    gear_retractable BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS logentries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pilot_id INT,
    aircraft_id INT,
    departure_place VARCHAR(50) NOT NULL,
    departure_time TIMESTAMP NOT NULL,
    arrival_place VARCHAR(50) NOT NULL,
    arrival_time TIMESTAMP NOT NULL,
    multi_engine BOOLEAN NOT NULL,
    total_time INT NOT NULL,
    takeoffs INT NOT NULL,
    landings INT NOT NULL,
    pilot_fun_command INT NOT NULL,
    pilot_fun_copilot INT NOT NULL,
    pilot_fun_dual INT NOT NULL,
    pilot_fun_instructor INT NOT NULL,
    remarks VARCHAR(500),
    FOREIGN KEY (pilot_id) REFERENCES pilots(id),
    FOREIGN KEY (aircraft_id) REFERENCES aircrafts(id)
);


-- Insert sample data into pilot table
INSERT INTO pilots (pilot_name, password, student, ppl, cpl, atpl, hp, complex, gear, tail)
VALUES
('Alice Smith', '$2y$10$yyTbS0rlSfOFNl2TaNOlCO2KJBjmAhS5c0i62rTCqDLwCjJi5wVJS', TRUE, '2022-01-15 10:00:00', NULL, NULL, FALSE, FALSE, FALSE, FALSE),
('Bob Johnson', '$2y$10$DmwEstWVs.tmM6tizV8XiO0LUTRvyGTczrsQKVyjrtFDOLhsQnQzC', FALSE, '2020-05-20 14:00:00', '2022-06-12 08:00:00', NULL, TRUE, TRUE, TRUE, FALSE),
('Charlie Brown', '$2y$10$/F5ZUkcsjvzHAxAUM65DUuoPEwfHS6kgs3dZh8hJTeG6eOH0ECO5e', FALSE, '2018-03-22 09:30:00', '2020-07-19 11:00:00', '2023-02-10 07:30:00', TRUE, TRUE, TRUE, TRUE);

-- Insert sample data into aircraft table
INSERT INTO aircrafts (make, registration, high_performance, taildragger, complex, gear_retractable)
VALUES
('Cessna', 'N12345', FALSE, FALSE, FALSE, FALSE),
('Piper', 'N67890', FALSE, TRUE, TRUE, TRUE),
('Beechcraft', 'N54321', TRUE, FALSE, TRUE, TRUE);

-- Insert sample data into logentry table
INSERT INTO logentries (pilot_id, aircraft_id, departure_place, departure_time, arrival_place, arrival_time, multi_engine, total_time, takeoffs, landings, pilot_fun_command, pilot_fun_copilot, pilot_fun_dual, pilot_fun_instructor, remarks)
VALUES
(1, 1, 'LAX', '2023-07-01 06:00:00', 'SFO', '2023-07-01 08:00:00', FALSE, 2, 1, 1, 2, 0, 0, 0, 'Routine training flight'),
(2, 2, 'JFK', '2023-07-15 09:00:00', 'BOS', '2023-07-15 10:30:00', FALSE, 1.5, 1, 1, 1, 0, 0, 0, 'Checked out on new aircraft'),
(3, 3, 'ORD', '2023-07-20 07:30:00', 'DFW', '2023-07-20 11:00:00', TRUE, 3.5, 2, 2, 3, 0, 0, 0, 'Multi-engine training'),
(1, 2, 'LAX', '2023-07-02 07:00:00', 'ORD', '2023-07-02 09:30:00', TRUE, 2.5, 1, 1, 1, 1, 1, 0, 'Cross-country flight'),
(1, 3, 'ORD', '2023-07-03 10:00:00', 'ATL', '2023-07-03 13:00:00', FALSE, 3, 1, 2, 2, 1, 0, 1, 'Flight training with multi-engine aircraft'),
(1, 1, 'ATL', '2023-07-04 08:00:00', 'JFK', '2023-07-04 11:00:00', FALSE, 3, 1, 1, 2, 1, 1, 0, 'Long haul flight'),
(1, 2, 'JFK', '2023-07-05 12:00:00', 'LAX', '2023-07-05 15:30:00', TRUE, 3.5, 2, 2, 1, 1, 0, 0, 'International flight'),
(1, 3, 'LAX', '2023-07-06 09:00:00', 'SFO', '2023-07-06 11:00:00', FALSE, 2, 1, 1, 1, 2, 0, 0, 'Short trip'),
(1, 1, 'SFO', '2023-07-07 06:30:00', 'LAX', '2023-07-07 08:30:00', FALSE, 2, 1, 0, 2, 1, 0, 0, 'Routine flight'),
(1, 2, 'LAX', '2023-07-08 07:30:00', 'ORD', '2023-07-08 10:00:00', TRUE, 2.5, 1, 1, 1, 1, 0, 0, 'Cross-country training'),
(1, 3, 'ORD', '2023-07-09 09:00:00', 'ATL', '2023-07-09 12:00:00', FALSE, 3, 1, 1, 1, 2, 1, 0, 'Flight with multi-engine'),
(1, 1, 'ATL', '2023-07-10 10:00:00', 'JFK', '2023-07-10 13:00:00', FALSE, 3, 1, 1, 2, 1, 0, 0, 'Routine flight'),
(1, 2, 'JFK', '2023-07-11 11:00:00', 'LAX', '2023-07-11 14:00:00', TRUE, 3.5, 2, 2, 1, 1, 0, 1, 'Extended flight training'),
(1, 3, 'LAX', '2023-07-12 07:30:00', 'SFO', '2023-07-12 09:30:00', FALSE, 2, 1, 1, 1, 1, 0, 0, 'Short-haul flight'),
(1, 1, 'SFO', '2023-07-13 08:00:00', 'LAX', '2023-07-13 10:00:00', FALSE, 2, 1, 1, 1, 1, 0, 0, 'Routine flight'),
(1, 2, 'LAX', '2023-07-14 09:00:00', 'ORD', '2023-07-14 11:30:00', TRUE, 2.5, 1, 1, 1, 1, 1, 0, 'Cross-country flight'),
(1, 3, 'ORD', '2023-07-15 10:00:00', 'ATL', '2023-07-15 12:30:00', FALSE, 3, 1, 1, 2, 1, 0, 1, 'Flight with multi-engine aircraft'),
(1, 1, 'ATL', '2023-07-16 11:00:00', 'JFK', '2023-07-16 14:00:00', FALSE, 3, 1, 1, 2, 1, 1, 0, 'Routine flight'),
(1, 2, 'JFK', '2023-07-17 12:00:00', 'LAX', '2023-07-17 15:30:00', TRUE, 3.5, 2, 2, 1, 1, 1, 0, 'Extended flight'),
(1, 3, 'LAX', '2023-07-18 06:00:00', 'SFO', '2023-07-18 08:30:00', FALSE, 2, 1, 1, 1, 1, 0, 0, 'Short-haul flight');