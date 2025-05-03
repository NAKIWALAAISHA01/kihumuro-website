-- Create the database
CREATE DATABASE IF NOT EXISTS kihumuro_hospital;
USE kihumuro_hospital;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'patient') NOT NULL DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    appointment_date DATE NOT NULL,
    message TEXT,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Contacts table
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Departments table
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doctors table
CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    department_id INT,
    specialization VARCHAR(100),
    qualification TEXT,
    experience INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (department_id) REFERENCES departments(id)
);

-- Insert initial departments
INSERT INTO departments (name, description) VALUES
('General Medicine', 'General medical care and consultations'),
('Cardiology', 'Heart and cardiovascular system care'),
('Orthopedics', 'Bone and joint care'),
('Pediatrics', 'Child healthcare'),
('Dermatology', 'Skin care and treatment'),
('Neurology', 'Brain and nervous system care');

-- Insert initial admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@kihumurohospital.com', '$2y$10$8KzWmJ3XgJZ6Z6Z6Z6Z6Z.8KzWmJ3XgJZ6Z6Z6Z6Z6Z', 'admin');

-- Insert sample doctors
INSERT INTO users (name, email, password, role) VALUES
('Dr. John Smith', 'dr.smith@kihumurohospital.com', '$2y$10$8KzWmJ3XgJZ6Z6Z6Z6Z6Z.8KzWmJ3XgJZ6Z6Z6Z6Z6Z', 'doctor'),
('Dr. Sarah Johnson', 'dr.johnson@kihumurohospital.com', '$2y$10$8KzWmJ3XgJZ6Z6Z6Z6Z6Z.8KzWmJ3XgJZ6Z6Z6Z6Z6Z', 'doctor');

-- Insert doctor details
INSERT INTO doctors (user_id, department_id, specialization, qualification, experience) VALUES
(2, 1, 'General Medicine', 'MD, Internal Medicine', 15),
(3, 2, 'Cardiology', 'MD, Cardiology', 12);

-- Create indexes for better performance
CREATE INDEX idx_appointments_email ON appointments(email);
CREATE INDEX idx_appointments_date ON appointments(appointment_date);
CREATE INDEX idx_contacts_email ON contacts(email); 