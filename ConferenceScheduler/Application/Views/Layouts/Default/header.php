<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>
        Conference Manager
    </title>
    <link rel="stylesheet" href="/Content/css.css"/>
    <link rel="stylesheet" href="/Content/bootstrap.css"/>

    <script src="http://code.jquery.com/jquery-2.1.4.js"></script>

</head>
<body>
<?php include('messages.php'); ?>
<div class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a href="../" class="navbar-brand">Home</a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <?php if(\ConferenceScheduler\Core\HttpContext\HttpContext::getInstance()->session('username')) : ?>
                    <li> <a href="#">My Schedule</a></li>
                    <li> <a href="/Conference/Create">New Conference</a></li>
                <?php endif; ?>
            </ul>
            <?php if(!\ConferenceScheduler\Core\HttpContext\HttpContext::getInstance()->session('username')) : ?>
                <ul class="nav navbar-nav navbar-right">
                <li><a href="/Account/Register">Register</a></li>
                <li><a href="/Account/Login">Login</a></li>
            </ul>
            <?php else : ?>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Hello, <?php
                        echo strtoupper(\ConferenceScheduler\Core\HttpContext\HttpContext::getInstance()->session('username')) ?></a></li>
                <li><a href="/account/logout">Logout</a></li>
            <?php endif; ?>
        </div>
    </div>
</div>