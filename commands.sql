CREATE DATABASE XXXXXX;
GRANT ALL ON XXXXXX.* TO YYYYYY@localhost
IDENTIFIED BY 'ZZZZZZ';
USE XXXXXX;

CREATE TABLE users (
    id                     INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tw_user_id             VARCHAR(30) UNIQUE,
    tw_screen_name         VARCHAR(15),
    tw_access_token_secret VARCHAR(255),
    created                DATETIME,
    modified               DATETIME
);