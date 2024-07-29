CREATE DATABASE IF NOT EXISTS digilog_db;

USE digilog_db;

CREATE TABLE IF NOT EXISTS pilot (
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

CREATE TABLE IF NOT EXISTS aircraft (
    id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(100) NOT NULL,
    registration VARCHAR(100) NOT NULL,
    high_performance BOOLEAN NOT NULL,
    taildragger BOOLEAN NOT NULL,
    complex BOOLEAN NOT NULL,
    gear_retractable BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS logentry (
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
    FOREIGN KEY (pilot_id) REFERENCES pilot(id),
    FOREIGN KEY (aircraft_id) REFERENCES aircraft(id)
);


-- Insert sample data into pilot table
INSERT INTO pilot (pilot_name, password, student, ppl, cpl, atpl, hp, complex, gear, tail)
VALUES
('Alice Smith', 'securepassword1', TRUE, '2022-01-15 10:00:00', NULL, NULL, FALSE, FALSE, FALSE, FALSE),
('Bob Johnson', 'securepassword2', FALSE, '2020-05-20 14:00:00', '2022-06-12 08:00:00', NULL, TRUE, TRUE, TRUE, FALSE),
('Charlie Brown', 'securepassword3', FALSE, '2018-03-22 09:30:00', '2020-07-19 11:00:00', '2023-02-10 07:30:00', TRUE, TRUE, TRUE, TRUE);

-- Insert sample data into aircraft table
INSERT INTO aircraft (make, registration, high_performance, taildragger, complex, gear_retractable)
VALUES
('Cessna', 'N12345', FALSE, FALSE, FALSE, FALSE),
('Piper', 'N67890', FALSE, TRUE, TRUE, TRUE),
('Beechcraft', 'N54321', TRUE, FALSE, TRUE, TRUE);

-- Insert sample data into logentry table
INSERT INTO logentry (pilot_id, aircraft_id, departure_place, departure_time, arrival_place, arrival_time, multi_engine, total_time, takeoffs, landings, pilot_fun_command, pilot_fun_copilot, pilot_fun_dual, pilot_fun_instructor, remarks)
VALUES
(1, 1, 'LAX', '2023-07-01 06:00:00', 'SFO', '2023-07-01 08:00:00', FALSE, 2, 1, 1, 2, 0, 0, 0, 'Routine training flight'),
(2, 2, 'JFK', '2023-07-15 09:00:00', 'BOS', '2023-07-15 10:30:00', FALSE, 1.5, 1, 1, 1, 0, 0, 0, 'Checked out on new aircraft'),
(3, 3, 'ORD', '2023-07-20 07:30:00', 'DFW', '2023-07-20 11:00:00', TRUE, 3.5, 2, 2, 3, 0, 0, 0, 'Multi-engine training');