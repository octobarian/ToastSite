<?php require_once 'config.inc.php'; ?>
    <?php
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

        if(isset($_GET['ison'])){
          $ison = $_GET['ison'];
          $sql = "select * from countries where ISONumeric = $ison";
        }
        else{
          $sql = "select * from countries";
        }

        $json = array();

        // if ($result = mysqli_query($connection, $sql)) {
        //     //https://stackoverflow.com/questions/383631/json-encode-mysql-results
        //       while($r = mysqli_fetch_assoc($result)) {
        //         $json[] = $r;
        //       }

        //     // release the memory used by the result set
        //     mysqli_free_result($result);
        // }

        if($result = mysqli_query($connection, $sql)){
          while ($row = mysqli_fetch_assoc($result)){
            $json[] = $row;
          }
        }

        // close the database connection
        mysqli_close($connection);
        echo json_encode($json);
        ?>
