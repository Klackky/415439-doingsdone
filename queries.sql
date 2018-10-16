INSERT INTO users (registration_date, email, name, password) VALUES
('2017-12-20', 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'),
('2018-05-04', 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'),
('2018-02-07', 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW');

INSERT INTO projects (title, user_id) VALUES
('Входящие', 1),
('Учеба', 1),
('Работа', 1),
('Домашние дела', 1),
('Авто', 1),
('Литература', 2),
('Курсы фотографии', 2),
('Создание портфолио', 2),
('Досуг', 2);

INSERT INTO tasks (project_id, user_id, created, completed, deadline, title, link) VALUES
(1, 1, '2018-03-06', 1, '2018-03-26', 'Собеседование в IT компании', NULL),
(1, 1, '2018-03-06', 0, '2018-03-26', 'Выполнить тестовое задание', NULL),
(1, 1, '2018-03-06', 0, '2018-03-26', 'Сделать задание первого раздела', NULL),
(1, 1, '2018-08-11', 1, '2018-03-26', 'Встреча с другом', NULL),
(1, 1, '2018-04-16', 0, '2018-03-26', 'Купить корм для кота', NULL),
(1, 1, '2017-11-06', 1, '2018-03-26', 'Заказать пиццу', NULL),
(6, 2, '2017-11-06', 1, '2018-03-26', 'Прочитать Красавчик Марселя Эме', NULL),
(7, 2, '2018-08-06', 0, '2018-03-26', 'Прочитать Humans of New York', NULL),
(8, 2, '2018-08-06', 0, '2018-03-27', 'Выбрать макет', NULL),
(9, 2, '2018-08-11', 0, '2018-03-26', 'Сходить на концерт Radiohead', NULL),
(9, 2, '2018-03-06',0, '2018-11-26', 'Отправить заявку в экспедицию на Амазонку', NULL),
(6, 2, '2018-09-05', 0, '2018-10-03', 'Прочитать Женщину в Белом Уилки Коллинза', NULL);

SELECT * FROM projects WHERE user_id = 1;
SELECT * FROM tasks WHERE project_id = 2;
UPDATE tasks SET is_completed = 1 WHERE task_id = 3;
UPDATE tasks SET title = 'Собеседование в фармацевтической компании' WHERE task_id = 2;


