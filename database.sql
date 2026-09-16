CREATE DATABASE IF NOT EXISTS naturestudylab
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE naturestudylab;

CREATE TABLE IF NOT EXISTS contact_messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(254) NOT NULL,
    topic VARCHAR(80) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_contact_messages_created_at (created_at),
    INDEX idx_contact_messages_topic (topic)
) ENGINE=InnoDB;