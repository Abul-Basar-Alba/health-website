CREATE DATABASE health_db;
USE health_db;

CREATE TABLE foods (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    description TEXT,
    nutrients JSON,
    image_path VARCHAR(255)
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    weight FLOAT,
    protein_needs FLOAT,
    calcium_needs FLOAT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO foods (name, description, nutrients, image_path) VALUES
('Spinach', 'Rich in iron and calcium', '["Protein", "Calcium", "Vitamin A"]', 'assets/images/spinach.jpg'),
('Salmon', 'High in omega-3 and protein', '["Protein", "Omega-3", "Vitamin D"]', 'assets/images/salmon.jpg'),
('Almonds', 'Great source of healthy fats and calcium', '["Protein", "Calcium", "Vitamin E"]', 'assets/images/almonds.jpg');