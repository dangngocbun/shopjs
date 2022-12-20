<?php
require_once 'core/function.php';

unset($_SESSION['user']);
header('Location: index.php');