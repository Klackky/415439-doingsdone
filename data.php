<?php

$projects = [
  'incoming' => 'Входящие',
  'education' => 'Учеба',
  'work' => 'Работа',
  'housework' => 'Домашние дела',
  'auto' => 'Авто'
];
$tasks = [
  [
    'title' => 'Собеседование в IT компании',
    'date' => '20.09.2018',
    'type' => $projects['work'],
    'completed' => false
  ],
  [
    'title' => 'Выполнить тестовое задание',
    'date' => '25.12.2018',
    'type' => $projects['work'],
    'completed' => false
  ],
  [
    'title' => 'Сделать задание первого раздела',
    'date' => '21.12.2018',
    'type' => $projects['education'],
    'completed' => true
  ],
  [
    'title' => 'Встреча с другом',
    'date' => '22.12.2018',
    'type' => $projects['incoming'],
    'completed' => false
  ],
  [
    'title' => 'Купить корм для кота',
    'date' => false,
    'type' => $projects['housework'],
    'completed' => false
  ],
  [
    'title' => 'Заказать пиццу',
    'date' => false,
    'type' => $projects['housework'],
    'completed' => false
  ]
  ];
?>
