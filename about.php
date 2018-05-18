<?php
/**
 * Created by PhpStorm.
 * User: N
 * Date: 2018/5/18
 * Time: 14:40
 */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Server list</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-material-design-dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="bootstrap-material-design-dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
    <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
</head>

<body>

<nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="/gamedb-php/servers-list.php">The Game Database</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/gamedb-php/servers-list.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/gamedb-php/about.php">About <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>

<div class="container" style="margin-top: 96px">

    <h1 class="display-1" style="margin-bottom: 64px">About</h1>
    <p>The Game Database is an application for demonstrating some database operations, including create, retrieve, update and delete (CRUD).</p>
    <p>It's my database course's project work in mid 2018.</p>
    <p>Developed on Apache 2.4, PHP 7.2, PostgreSQL 9.6 and Bootstrap 4.1.</p>
    <p>Created by 左振宇.</p>
    <p>Student ID: 1610842.</p>
    <p>The source code can be found <a href="https://github.com/mixplugs/gamedb-php">here</a>.</p>


</div>

</body>

</html>
