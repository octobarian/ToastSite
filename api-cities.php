<?php require_once 'config.inc.php'; ?>
    <?php
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

        if (mysqli_connect_errno()) {
            die(mysqli_connect_error());
        }

        if(isset($_GET['iso'])){
          $iso = $_GET['iso'];
          $sql = "select * from cities where ISO = $iso";
        }
        else{
          $sql = "select * from cities";
        }

        $json = array();

        if ($result = mysqli_query($connection, $sql)) {
            // loop through the data
            while ($row = mysqli_fetch_assoc($result)) {
              $json[] = $row;
                )
            }
            // release the memory used by the result set
            mysqli_free_result($result);
        }
        // close the database connection
        mysqli_close($connection);
        echo json_encode($json); 
        ?>
