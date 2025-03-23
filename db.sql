DROP DATABASE IF EXISTS garage13;

CREATE DATABASE garage13;

USE garage13;

CREATE TABLE CarType (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
INSERT INTO CarType (name) VALUES ('Sport'), ('Citadine'), ('SUV');

CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role JSON NOT NULL
);

-- Refaire password a la main avec password_hash()
-- password: admin
INSERT INTO User (username, password, role) VALUES
('admin', '$2y$10$lEIPhc1a.NUi59PgcfMn.et3BBmwTLoXm2FFU53FZC2zYC0yCJR/i', '["ADMIN"]'),
('owner1', '$2y$10$lEIPhc1a.NUi59PgcfMn.et3BBmwTLoXm2FFU53FZC2zYC0yCJR/i', '["CAR_OWNER","CAR_LESSEE"]'),
('owner2', '$2y$10$lEIPhc1a.NUi59PgcfMn.et3BBmwTLoXm2FFU53FZC2zYC0yCJR/i', '["CAR_OWNER","CAR_LESSEE"]'),
('lessee1', '$2y$10$lEIPhc1a.NUi59PgcfMn.et3BBmwTLoXm2FFU53FZC2zYC0yCJR/i', '["CAR_LESSEE"]'),
('lessee2', '$2y$10$lEIPhc1a.NUi59PgcfMn.et3BBmwTLoXm2FFU53FZC2zYC0yCJR/i', '["CAR_LESSEE"]');

CREATE TABLE Car (
    id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(255) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    horsePower INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    car_type_id INT NOT NULL,
    owner_id INT NOT NULL,
    FOREIGN KEY (car_type_id) REFERENCES CarType(id),
    FOREIGN KEY (owner_id) REFERENCES User(id)
);


INSERT INTO Car (model, brand, horsePower, image, car_type_id, owner_id) VALUES 
('Ferrari 488', 'Ferrari', 670, 'modelS.png', 1, 2), 
('Toyota Yaris', 'Toyota', 120, 'https://example.com/yaris.jpg', 2, 2), 
('BMW X5', 'BMW', 400, 'https://example.com/bmw_x5.jpg', 3, 3), 
('Porsche 911', 'Porsche', 450, 'https://example.com/porsche_911.jpg', 1, 3);

CREATE TABLE Rental (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    renter_id INT NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected', 'Completed') NOT NULL,
    FOREIGN KEY (car_id) REFERENCES Car(id),
    FOREIGN KEY (renter_id) REFERENCES User(id)
);

-- Insertion des voitures
-- Insertion des locations
INSERT INTO Rental (car_id, renter_id, start_date, end_date, status) VALUES 
(1, 4, '2025-03-22 10:00:00', '2025-03-24 10:00:00', 'Pending'), 
(2, 5, '2025-03-25 09:00:00', '2025-03-30 09:00:00', 'Approved');

