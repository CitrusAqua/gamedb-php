<?php
/**
 * Created by PhpStorm.
 * User: N
 * Date: 2018/5/19
 * Time: 19:54
 */

$host        = "host=127.0.0.1";
$port        = "port=5432";
$dbname      = "dbname=gamedb";
$credentials = "user=gamedbuser password=gPassword";

$db = pg_connect( "$host $port $dbname $credentials"  );

$create_item_success = isset($_GET['create_item']) ? $_GET['create_item'] : null;
$delete_item_success = isset($_GET['delete_item']) ? $_GET['delete_item'] : null;

?>

<?php
if(isset($_POST['new_item'])) {
    $new_name = $_POST['new_name'];
    $new_value = $_POST['new_value'];
    $query = pg_query($db, "INSERT INTO items(name, value) VALUES('$new_name', $new_value);");
    if ($query) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?create_item=true');
        exit;
    } else {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?create_item=false');
        exit;
    }
}
if(isset($_POST['destroy'])) {
    $item_id = $_POST['destroy'];
    $query = pg_query($db, "DELETE FROM items WHERE id = $item_id;");
    if ($query) {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?delete_item=true');
        exit;
    } else {
        header("Location: " . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?delete_item=false');
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

<nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
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

<div class="container">

    <div class="row bg-primary text-white" style="margin-top:104px; margin-bottom:16px; padding: 48px;">
        <div class="col">
            <h1 class="display-2">Item List</h1>
            <p>All items in this game will be displayed here.</p>
        </div>
    </div>

    <div class="row" style="padding-right: 20px;">
        <div class="col">
            <div class="btn-group-vertical float-right">
                <button type="button" class="btn btn-raised btn-primary" data-toggle="modal" data-target="#newItem">New item</button>
            </div>

            <div class="modal fade" id="newItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newPlayerLabel">New item</h5>
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
                                    <label for="valueInput">Value</label>
                                    <input type="number" class="form-control" id="valueInput" name="new_value">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="new_item" value=true >Create Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!isset($create_item_success)) {}
    elseif ($create_item_success == 'true') {
        echo <<<EOF
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Successfully created item.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOF;
    } else {
        echo <<<EOF
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Failed to create item. Something went wrong.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOF;
    }

    if (!isset($delete_item_success)) {}
    elseif ($delete_item_success == 'true') {
        echo <<<EOF
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Successfully deleted item.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOF;
    } else {
        echo <<<EOF
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Failed to delete item. Something went wrong.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
EOF;
    }

    ?>

    <table class="table table-hover" style="margin-top:24px;">
        <thead>
        <tr>
            <th>Item ID</th>
            <th>Name</th>
            <th>Value</th>
            <th>Operation</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // $item_list = pg_query($db, "SELECT * FROM item_count WHERE server_id = $server_id;");
        $item_list = pg_query($db, "SELECT * FROM items;");
        while ($row = pg_fetch_row($item_list)) {
            echo <<<EOF
        <tr>
            <td class="align-middle">$row[0]</td>
            <td class="align-middle">$row[1]</td>
            <td class="align-middle">$row[2]</td>
            <td>
                <button type="button" class="btn btn-danger" style="margin:0px;" data-toggle="modal" data-target="#deleteModal$row[0]">Delete</button>
            </td>
        </tr>
        
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
                        You will delete this item. Are you sure?
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

EOF;
        }
        ?>

        </tbody>
    </table>

</div>

</body>

</html>