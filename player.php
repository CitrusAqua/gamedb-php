<?php
/**
 * Created by PhpStorm.
 * User: N
 * Date: 2018/5/17
 * Time: 17:43
 */
$server_id = $_GET['server_id'];
$player_id = $_GET['player_id'];
$add_item_success = isset($_GET['add_item']) ? $_GET['add_item'] : null;

$host        = "host=127.0.0.1";
$port        = "port=5432";
$dbname      = "dbname=gamedb";
$credentials = "user=gamedbuser password=gPassword";

$db = pg_connect( "$host $port $dbname $credentials"  );

$player = pg_query($db, "SELECT * FROM players WHERE server_id = $server_id AND id = '$player_id' ;");
$holds = pg_query($db, "SELECT * FROM holds WHERE server_id = $server_id AND player_id = '$player_id' ;");

?>

<?php
if(isset($_POST['add_item'])) {
    $new_id = $_POST['new_id'];
    $new_quantity = $_POST['new_quantity'];
    $query = pg_query($db, "SELECT * FROM add_item($server_id, $player_id, $new_id, $new_quantity);");
    //Header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . 'id=' . $id . '&create_player=true');
    if ($query) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . 'server_id=' . $server_id . '&player_id=' . $player_id. '&add_item=true');
        exit;
    } else {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . 'server_id=' . $server_id . '&player_id=' . $player_id. '&add_item=false');
        exit;
    }
}
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
        <li class="breadcrumb-item active" aria-current="page">Player</li>
    </ol>
</nav>

<div class="container">



    <div class="row h-100">
        <div class="col bg-primary text-white" style="max-width: 370px; height: 660px; padding-top: 40px;padding-left: 28px">
            <?php
            $player_name = pg_fetch_result($player, 2);
            $player_level = pg_fetch_result($player, 3);
            $player_health = pg_fetch_result($player, 4);
            $player_career = pg_fetch_result($player, 5);
            echo <<<EOF
                <h1 style="margin-bottom: 36px">$player_name</h1>
                <h5>level: $player_level</h5>
                <h5>health: $player_health</h5>
                <h5>career: $player_career</h5>
EOF;
            ?>
        </div>

        <div class="col">
            <div class="row">
                <div class="col align-self-start" style="padding-left: 36px; padding-top: 12px">
                    <h3>Item held</h3>
                </div>
                <div class="col align-self-end">
                    <div class="btn-group-vertical float-right">
                        <button type="button" class="btn btn-raised btn-primary" data-toggle="modal" data-target="#addItem">Add item</button>

                        <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newPlayerLabel">Add Item</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="levelInput">Item ID</label>
                                                <input type="number" class="form-control" id="levelInput" name="new_id">
                                            </div>
                                            <div class="form-group">
                                                <label for="healthInput">Quantity</label>
                                                <input type="number" class="form-control" id="healthInput" name="new_quantity">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary" name="add_item" value=true >Add Item</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?php
            if (!isset($add_item_success)) {}
            elseif ($add_item_success == 'true') {
                echo <<<EOF
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Successfully added item.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
EOF;
            } else {
                echo <<<EOF
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Failed to add item. Something went wrong.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
EOF;
            }
            ?>

            <div class="col" style="margin:0px;padding:0px;">
                <div class="d-flex flex-wrap">
                    <?php
                    while ($row = pg_fetch_row($holds)) {
                        $item = pg_query($db, "SELECT * FROM items WHERE id = $row[2];");
                        $item_name = pg_fetch_result($item,1);
                        $item_value = pg_fetch_result($item,2);
                        echo <<<EOF
                            <div class="card" style="min-width: 220px; margin: 12px;">
                                <div class="card-body" style="padding-bottom: 10px">
                                    <h4 class="card-title" style="margin-right: 20px;">$item_name</h4>
                                    <h6>value: $item_value</h6>
                                    <h6>quantity: $row[3]</h6>
                                </div>
                                
                                <div class="card-footer" style="padding-right: 8px; padding-bottom: 5px; padding-top: 8px">
                                    <a href="/gamedb-php/item.php?item_id=$row[2]" class="btn btn-primary float-right">Detail</a>
                                </div>
                            
                            </div>
EOF;
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>

