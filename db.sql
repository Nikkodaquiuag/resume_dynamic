-- Create database
CREATE DATABASE resume_dynamic;
USE resume_dynamic;

-- Table: About
CREATE TABLE about (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL
);

-- Table: Skills
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(100) NOT NULL,
    proficiency VARCHAR(50) DEFAULT NULL
);

-- Table: Projects
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_title VARCHAR(255) NOT NULL,
    description TEXT,
    link VARCHAR(255)
);

-- Table: Education & Certification
CREATE TABLE education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institution VARCHAR(255) NOT NULL,
    degree VARCHAR(255),
    year VARCHAR(50),
    certification VARCHAR(255)
);
