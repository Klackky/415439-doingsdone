INSERT INTO users (user_id, registration_date, email, name, password) VALUES
(1, '2017-12-20', 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'),
(2, '2018-05-04', 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'),
(3 ,'2018-02-07', 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW');

INSERT INTO users (registration_date, email, name, password) VALUES
('2017-12-20', 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'),
('2018-05-04', 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'),
('2018-02-07', 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW');

INSERT INTO projects (project_id, title, user_id) VALUES
(1, 'Входящие', 1),
(2, 'Учеба', 1),
(3, 'Работа', 1),
(4, 'Домашние дела', 1),
(5, 'Авто', 1)

INSERT INTO tasks (user_id, project_id, created, completed, deadline, title, link) VALUES
(1, 1, '2018-03-06', '2018-04-05', '2018-03-26', 'Собеседование в IT компании', NULL),
(1, 1, '2018-03-06', NULL, '2018-03-26', 'Выполнить тестовое задание', NULL),
(1, 1, '2018-03-06', NULL, '2018-03-26', 'Сделать задание первого раздела', NULL),
(1, 1, '2018-08-11', NULL, '2018-03-26', 'Встреча с другом', NULL),
(1, 1, '2018-04-16', NULL, '2018-03-26', 'Купить корм для кота', NULL),
(1, 1, '2017-11-06', NULL, '2018-03-26', 'Заказать пиццу', NULL),

SELECT * FROM projects WHERE user_id = 1;
SELECT * FROM tasks WHERE project_id = 2;
UPDATE tasks SET is_completed = 1 WHERE task_id = 3;
SELECT * FROM tasks WHERE deadline = '2018-09-27';
UPDATE tasks SET title = 'Собеседование в фармацевтической компании' WHERE task_id = 2;


--попробовала джойны
SELECT * FROM projects JOIN users ON (projects.user_id = users.user_id) WHERE users.name = 'Игнат' AND projects.project_id = 1;
