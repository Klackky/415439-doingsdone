CREATE DATABASE IF NOT EXISTS doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingsdone;


CREATE TABLE projects (
  project_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  title CHAR(30) NOT NULL,
  user_id INT NOT NULL
);

CREATE TABLE tasks (
  task_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  project_id INT NOT NULL,
  created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  completed DATETIME,
  deadline DATETIME,
  title TEXT(30) NOT NULL,
  link TEXT(300)
);

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  registration_date DATETIME NOT NULL,
  email CHAR(50) NOT NULL,
  name CHAR(20) NOT NULL,
  password CHAR(255) NOT NULL,
  contact_info CHAR(100)
);

CREATE UNIQUE INDEX email ON user(email);
CREATE UNIQUE INDEX name ON user(name);
