<?php

require_once('functions.php');
require_once('helpers.php');
$show_complete_tasks = 1;
$con=mysqli_connect('localhost','root','','doingsdone');
mysqli_set_charset($con,"utf8");


$sql_projects_list =
"SELECT projects.project_name as name, COUNT(*) AS task_count FROM projects
JOIN tasks ON projects.id = tasks.project_id
WHERE tasks.user_id=2
GROUP BY tasks.project_id;";

$result_projects_list = mysqli_query($con,$sql_projects_list);
test_result($result_projects_list,$sql_projects_list);
$projects_list = mysqli_fetch_all($result_projects_list,MYSQLI_ASSOC);

$sql_tasks_list = "SELECT title,status AS done,due_date AS date FROM tasks WHERE user_id=2";
$result_tasks_list = mysqli_query($con,$sql_tasks_list);
test_result($result_tasks_list,$sql_tasks_list);
$tasks_list = mysqli_fetch_all($result_tasks_list,MYSQLI_ASSOC);



$page_content = include_template('index.php', ['projects' => $projects_list,
                                               'doings'=> $tasks_list,
                                               'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content,
                                                  'title' => 'Дела в порядке',
                                                  'projects' => $projects_list,
                                                  'doings'=> $tasks_list, ]);

                                                  print($layout_content);