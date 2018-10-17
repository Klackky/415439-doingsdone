<?php
require_once('config.php');
var_dump($_SESSION);
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}
header('Location: index.php');
