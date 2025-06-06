-- Create Database
CREATE DATABASE IF NOT EXISTS tanishq_calculator;
USE tanishq_calculator;

-- Create jewelry types table
CREATE TABLE jewelry_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type_name VARCHAR(100) NOT NULL
);

-- Create jewelry designs table
CREATE TABLE jewelry_designs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jewelry_type_id INT NOT NULL,
    design_name VARCHAR(255) NOT NULL,
    weight_grams DECIMAL(10,2) NOT NULL,
    gemstone_count INT DEFAULT 0,
    making_charges DECIMAL(10,2) NOT NULL,
    wastage_percentage DECIMAL(5,2) NOT NULL,
    tax_percentage DECIMAL(5,2) NOT NULL,
    image_url VARCHAR(500),
    FOREIGN KEY (jewelry_type_id) REFERENCES jewelry_types(id)
);

-- Insert jewelry types
INSERT INTO jewelry_types (type_name) VALUES 
('Rings'),
('Necklaces'),
('Bracelets');

-- Insert jewelry designs based on your specifications
INSERT INTO jewelry_designs (jewelry_type_id, design_name, weight_grams, gemstone_count, making_charges, wastage_percentage, tax_percentage, image_url) VALUES 

-- Rings
(1, 'The Tanishq Classic Oval Gold Ring', 3.25, 1, 3500.00, 18.00, 3.00, 'https://example.com/ring1.jpg'),
(1, 'The Tanishq Rose Gold Diamond Ring', 2.8, 5, 5200.00, 20.00, 3.00, 'https://example.com/ring2.jpg'),
(1, 'The Mia Heart Design Gold Ring', 1.9, 2, 2000.00, 15.00, 3.00, 'https://example.com/ring3.jpg'),

-- Necklaces
(2, 'The Tanishq Traditional Gold Necklace', 68.3, 10, 15000.00, 22.00, 3.00, 'https://example.com/necklace1.jpg'),
(2, 'The Tanishq Diamond Floral Necklace', 35.6, 12, 18500.00, 20.00, 3.00, 'https://example.com/necklace2.jpg'),
(2, 'The Mia Lightweight Pendant Necklace', 12.4, 3, 4500.00, 16.00, 3.00, 'https://example.com/necklace3.jpg'),

-- Bracelets
(3, 'The Titan Link Bracelet for Men', 18.2, 0, 2800.00, 12.00, 18.00, 'https://example.com/bracelet1.jpg'),
(3, 'The Tanishq Gold Kada Bracelet', 25.0, 1, 6200.00, 19.00, 3.00, 'https://example.com/bracelet2.jpg'),
(3, 'The Mia Charm Bracelet', 10.5, 4, 3100.00, 14.00, 3.00, 'https://example.com/bracelet3.jpg');