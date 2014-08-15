<?php
session_start();

if (!defined('NO_AUTH')) {
    if (empty($_SESSION['userid'])) {
        var_dump($_SESSION);
//        header('Location: login.php');
//        exit();
    }
}

require_once('includes/db.inc.php');
require_once('includes/utils.inc.php');

if (!defined('PAGE_TITLE')) {
    define('PAGE_TITLE', 'My Web Blog');
}

?>
<html>
<head>
    <title><?php print PAGE_TITLE ?></title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="assets/css/tb.css" />

</head>
<body>
    <div class="page-header">
        <h1>My Web Blog</h1>
    </div>


