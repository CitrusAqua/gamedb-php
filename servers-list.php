<?php
/**
 * Created by PhpStorm.
 * User: N
 * Date: 2018/5/17
 * Time: 10:42
 */

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

<div class="container">

    <nav aria-label="breadcrumb" style="margin-bottom: 60px">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Server List</li>
        </ol>
    </nav>

    <h1>Server List</h1>
    <div class="list-group">

        <?php

        $server_list = pg_query($db, "SELECT * FROM servers;");

        while ($row = pg_fetch_row($server_list)) {
            echo <<<EOF
                <div class="card" style="max-width:760px; margin-top: 40px">
                    <div class="card-body">
                
                        <div class="container">
                            <div class="row">
                                <div class="col-sm">
                                    Server id:
                                    <h5 class="card-title">$row[0]</h5>
                                </div>
                
                                <div class="col-sm">
                                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                                        <a href="/gamedb-php/server.php?id=$row[0]" class="btn btn-primary">Show</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal$row[0]">Destroy</button>
                                    </div>
                                </div>
                
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal$row[0]" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmation" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Destroy server</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                You will destroy this server. Are you sure?
                                            </div>
                                            <form action="" method="post" style="margin:0px">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button name="destroy" value=$row[0] type="submit" class="btn btn-danger">Destroy</button>
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
            $id = $_POST['destroy'];
            $query = pg_query($db, "DELETE FROM servers WHERE id = '$id' ;");
            echo "<meta http-equiv='refresh' content='0'>";
        }


        ?>
    </div>
</div>

</body>

</html>