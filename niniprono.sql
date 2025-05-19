-- Création de la base de données
CREATE DATABASE niniprono;
USE niniprono;

-- Table pour les utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    age INT NOT NULL,
    motdepasse VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CHECK (age >= 18)  -- Contrainte pour s'assurer que l'âge est au moins 18 ans
);


-- Table pour les abonnements
CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('1_month', '3_months', '6_months') NOT NULL,  -- Utilisation d'ENUM pour limiter les valeurs possibles
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);


-- Table pour les pronostics
CREATE TABLE IF NOT EXISTS pronostics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_name VARCHAR(255) NOT NULL,
    match_date DATE NOT NULL,
    prediction VARCHAR(255) NOT NULL,
    odds DECIMAL(5, 2) NOT NULL,
    is_vip BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table pour les pronostics VIP
CREATE TABLE IF NOT EXISTS vip_pronostics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pronostic_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (pronostic_id) REFERENCES pronostics(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table pour les messages de contact
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
