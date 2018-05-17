<?php
/**
 * Created by PhpStorm.
 * User: N
 * Date: 2018/5/17
 * Time: 16:13
 */
$id = $_GET['id'];
$create_player_success = isset($_GET['create_player']) ? $_GET['create_player'] : null;

$host        = "host=127.0.0.1";
$port        = "port=5432";
$dbname      = "dbname=gamedb";
$credentials = "user=gamedbuser password=gPassword";

$db = pg_connect( "$host $port $dbname $credentials"  );

?>

<?php
if(isset($_POST['submit'])) {
    $new_name = $_POST['new_name'];
    $new_level = $_POST['new_level'];
    $new_health = $_POST['new_health'];
    $new_career = $_POST['new_career'];
    $query = pg_query($db, "INSERT INTO players(server_id, name, level, health, career) VALUES($id, '$new_name', $new_level, $new_health, '$new_career');");
    //Header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . 'id=' . $id . '&create_player=true');
    if ($query) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . 'id=' . $id . '&create_player=true');
        exit;
    } else {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . 'id=' . $id . '&create_player=false');
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

<div class="container">

    <nav aria-label="breadcrumb" style="margin-bottom: 60px">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/gamedb-php/servers-list.php">Server List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Player List</li>
        </ol>
    </nav>

    <div class="row" style="margin-bottom: 20px;">
        <div class="col">
            <div class="page-header">
                <h1>
                    Player List
                </h1>
                <h3>
                    Server id:<?php echo $id ?>
                </h3>
            </div>
        </div>

        <div class="col">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newPlayer">New player</button>
            <div class="modal fade" id="newPlayer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newPlayerLabel">New player</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nameInput">Name</label>
                                    <input type="text" class="form-control" id="nameInput" placeholder="Max 11 chars" name="new_name">
                                </div>
                                <div class="form-group">
                                    <label for="levelInput">Level</label>
                                    <input type="number" class="form-control" id="levelInput" name="new_level">
                                </div>
                                <div class="form-group">
                                    <label for="healthInput">Health</label>
                                    <input type="number" class="form-control" id="healthInput" name="new_health">
                                </div>
                                <div class="form-group">
                                    <label for="careerSelect">Example select</label>
                                    <select class="form-control" id="careerSelect" name="new_career">
                                        <option value="Knight">Knight</option>
                                        <option value="Mage">Mage</option>
                                        <option value="Priest">Priest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="submit" value=true >Create Player</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!isset($create_player_success)) {}
    elseif ($create_player_success == 'true') {
        echo <<<EOF
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Successfully created player.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOF;
    } else {
        echo <<<EOF
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Failed to create player. Something went wrong.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOF;
    }
    ?>

    <div class="list-group">

        <?php

        $player_list = pg_query($db, "SELECT * FROM players WHERE server_id = $id;");

        while ($row = pg_fetch_row($player_list)) {
            echo <<<EOF
                <div class="card" style="max-width:760px; margin-top: 20px; margin-bottom: 20px;">
                    <div class="card-body">
                
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    <h3 class="card-title">$row[2]</h3>
                                    <h6>level: $row[3]</h6>
                                    <h6>health: $row[4]</h6>
                                    <h6>career: $row[5]</h6>
                                </div>
                
                                <div class="col-sm">
                                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                                        <a href="/gamedb-php/player.php?server_id=$row[1]&player_id=$row[0]" class="btn btn-primary">Show</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal$row[0]">Delete</button>
                                    </div>
                                </div>
                
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal$row[0]" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmation" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Delete player</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                You will delete this player. Are you sure?
                                            </div>
                                            <form action="" method="post" style="margin:0px">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button name="destroy" value=$row[0] type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                
                            </div>
                        </div>
                
                    </div>
                </div>
EOF;

        }

        if(isset($_POST['destroy'])) {
            $player_id = $_POST['destroy'];
            $query = pg_query($db, "DELETE FROM players WHERE server_id = $id AND id = '$player_id' ;");
            echo "<meta http-equiv='refresh' content='0'>";
        }


        ?>
    </div>
</div>

</body>

</html>
