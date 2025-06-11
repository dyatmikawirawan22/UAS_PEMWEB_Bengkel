-- Create a database (optional, if not already created)
CREATE DATABASE IF NOT EXISTS chat_app;
USE chat_app;

-- Create table for storing chat messages
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id VARCHAR(255) DEFAULT NULL, -- You could expand this for user management
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
