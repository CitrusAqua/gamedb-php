<?php
/**
 * Created by PhpStorm.
 * User: N
 * Date: 2018/5/18
 * Time: 12:03
 */
$server_id = $_GET['server_id'];

$host        = "host=127.0.0.1";
$port        = "port=5432";
$dbname      = "dbname=gamedb";
$credentials = "user=gamedbuser password=gPassword";

$db = pg_connect( "$host $port $dbname $credentials"  );
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
                <a class="nav-link" href="/gamedb-php/servers-list.php">SERVERS <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/gamedb-php/items-list.php">ITEMS <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/gamedb-php/about.php">About <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<nav aria-label="breadcrumb" style="margin-bottom: 60px">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/gamedb-php/servers-list.php">Server List</a></li>
        <?php echo "<li class=\"breadcrumb-item\"><a href=\"/gamedb-php/server.php?id=$server_id\">Player List</a></li>"; ?>
        <li class="breadcrumb-item active" aria-current="page">Item Statistics</li>
    </ol>
</nav>

<div class="container">



    <div class="row" style="margin-bottom: 20px;">
        <div class="page-header">
            <h1>
                Item Statistics
            </h1>
            <h3>
                Server id:<?php echo $server_id ?>
            </h3>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Name</th>
                <th>Value</th>
                <th>Total Quantity</th>
                <th>Total Value</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // $item_list = pg_query($db, "SELECT * FROM item_count WHERE server_id = $server_id;");
        $item_list = pg_query($db, "SELECT * FROM items;");
        while ($row = pg_fetch_row($item_list)) {
            $item_c = pg_query($db, "SELECT * FROM item_count WHERE server_id = $server_id AND item_id = $row[0];");
            $total_quantity = pg_fetch_result($item_c, 2);
            if ($total_quantity == FALSE) {
                $total_quantity = 0;
            }
            $total_value = $total_quantity * $row[2];
            echo <<<EOF
                <tr>
                    <td>$row[0]</td>
                    <td>$row[1]</td>
                    <td>$row[2]</td>
                    <td>$total_quantity</td>
                    <td>$total_value</td>
                </tr>
EOF;
        }
        ?>
        </tbody>
    </table>

</div>

</body>
</html>

