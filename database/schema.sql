-- Create the database
CREATE DATABASE IF NOT EXISTS SomaliFitnessGym;
USE SomaliFitnessGym;

-- People table (for both members and staff)
CREATE TABLE IF NOT EXISTS people (
    p_no INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50) NOT NULL,
    lname VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    password VARCHAR(255),  -- For staff login
    role ENUM('admin', 'staff', 'member') NOT NULL DEFAULT 'member',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    membership_end DATE,    -- For members only
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Measurements table
CREATE TABLE IF NOT EXISTS measurements (
    m_no INT AUTO_INCREMENT PRIMARY KEY,
    p_no INT NOT NULL,
    weight DECIMAL(5,2),    -- in kg
    height DECIMAL(5,2),    -- in cm
    chest DECIMAL(5,2),     -- in cm
    waist DECIMAL(5,2),     -- in cm
    arms DECIMAL(5,2),      -- in cm
    legs DECIMAL(5,2),      -- in cm
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (p_no) REFERENCES people(p_no) ON DELETE CASCADE
);

-- Receipts table
CREATE TABLE IF NOT EXISTS receipts (
    r_no INT AUTO_INCREMENT PRIMARY KEY,
    p_no INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_type ENUM('cash', 'card', 'mobile') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (p_no) REFERENCES people(p_no) ON DELETE CASCADE
);

-- Insert default admin user
INSERT INTO people (fname, lname, phone, email, password, role) 
VALUES ('Admin', 'User', '123456789', 'admin@somalifitness.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin')
ON DUPLICATE KEY UPDATE updated_at = CURRENT_TIMESTAMP;
-- Default password is 'password'

-- Create indexes
CREATE INDEX idx_people_role ON people(role);
CREATE INDEX idx_people_status ON people(status);
CREATE INDEX idx_people_membership ON people(membership_end);
CREATE INDEX idx_measurements_date ON measurements(created_at);
CREATE INDEX idx_receipts_date ON receipts(created_at);
