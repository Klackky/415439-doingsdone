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
  project_id INT,
  user_id INT NOT NULL,
  created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  completed tinyint(1) NOT NULL DEFAULT '0',
  deadline DATETIME,
  title TEXT(100) NOT NULL,
  link TEXT(300),
  file TEXT(300)
);

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  registration_date DATETIME NOT NULL,
  email CHAR(50) NOT NULL,
  name CHAR(20) NOT NULL,
  password CHAR(255) NOT NULL,
  contact_info CHAR(100)
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX name ON users(name);
CREATE FULLTEXT INDEX tasks_search ON tasks (title);
