-- SQL script for generating the database tables with example entries, created one to fit the web app - 
-- modified for sqlLite instead of MySQL, GENERATED SQLITE DATABASE FILE WITH https://extendsclass.com/sqlite-browser.html#


DROP TABLE IF EXISTS module_staff;
DROP TABLE IF EXISTS interests;
DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS programmes;
DROP TABLE IF EXISTS staff;
DROP TABLE IF EXISTS users;

PRAGMA foreign_keys = ON;
--FOR ADMINS
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL
);

PRAGMA foreign_keys = ON;
--PROGRAMMES TABLE
CREATE TABLE programmes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    level TEXT NOT NULL,
    description TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);
PRAGMA foreign_keys = ON;
-- MODULES TABLE
CREATE TABLE modules (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    year INTEGER NOT NULL,
    shared INTEGER DEFAULT 0,
    programme_id INTEGER NOT NULL,
    FOREIGN KEY (programme_id) REFERENCES programmes(id)
);
PRAGMA foreign_keys = ON;
--STAFF TABLE
CREATE TABLE staff (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    role TEXT NOT NULL
);
PRAGMA foreign_keys = ON;
--RELATIONSHIPS TABLE BETWEEN STAFF AND MODULES
CREATE TABLE module_staff (
    module_id INTEGER NOT NULL,
    staff_id INTEGER NOT NULL,
    PRIMARY KEY (module_id, staff_id),
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE
);
PRAGMA foreign_keys = ON;
--INTERESTS TABLE (target)
CREATE  TABLE interests (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    programme_id INTEGER NOT NULL,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    module_id INTEGER NOT NULL,
    UNIQUE(email, programme_id),
    FOREIGN KEY (programme_id) REFERENCES programmes(id) ON DELETE CASCADE,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);
--POPULATION LOGIC
INSERT INTO users(name, email, password_hash) VALUES
('Admin User', 'admin@example.com', 'hash');

INSERT INTO programmes(name, level, description) VALUES
('Computer Science BSc', 'Undergraduate', 'Covers basic computer science principles'),
('Cyber Security Msc', 'Postgraduate', 'Focuses on advanced security skills');

INSERT INTO modules (title, year, programme_id, shared) VALUES
('Web Development', 2, 1, 0),
('OOP Principles', 1, 1, 0),
('Advanced Network Security Systems', 1, 2, 0),
('Cyber Threats', 2, 2, 0);

INSERT INTO staff (name, role) VALUES
('Dr. Bella Wallis', 'Programme Leader'),
('Prof. Aidan Murphy', 'Senior Lecturer'),
('Dr. Sam Knight', 'Lecturer');

INSERT INTO module_staff (module_id, staff_id) VALUES
(1, 1),
(2, 3),
(3, 2),
(4, 2);

INSERT INTO interests(email, programme_id, module_id) VALUES
('student1@example.com', 1, 1),
('student2@example.com', 2, 2);
