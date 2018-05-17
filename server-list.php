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
   $credentials = "user=postgres password=gPassword";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }
?>

