<?php
require "header.php";
require "includes/dbh.inc.php";
?>

<main>
    <div id="favList">
        <?php
        if (isset($_SESSION['favPhotos'])) {
            if (sizeof($_SESSION['favPhotos']) > 0) {
                foreach ($_SESSION['favPhotos'] as $i) {

                    if ($conn->connect_error) {
                        exit('Error connecting to the database');
                    }

                    $sql = "SELECT ImageID FROM imagedetails WHERE Path=?";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../index.php?error=sqlerror");
                        exit();
                    } else {
                        if ($i != null) {
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, "s", $i);
                        } else {
                            header("Location: //index.php?error=invalidFavoriteImage");
                        }

                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $id = mysqli_fetch_assoc($result);
                    }
                    mysqli_stmt_close($stmt);
                    echo '<div>';
                    echo '<a href="single-photo.php?ImageID=' . $id['ImageID'] . '">';
                    $img = '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/medium640/' . $i . '">';
                    echo $img;
                    createRemove($i);
                    echo '</div>';
                }
            } else {
                echo '<h1>No Favorites Saved</h1>';
            }
        }

        ?>
    </div>
</main>

<?php
require "footer.php";

function createRemove($i)
{
    echo '<form action="" method="post">';
    echo '<input type="hidden" name="path" value="' . $i . '">';
    echo '<input type="submit" name="remove" value="Remove from Favorites">';
    echo '</form>';
}

//stackoverflow.com/questions/2231332/how-to-remove-a-variable-from-a-php-session-array
if (isset($_POST['remove'])) {
    $location = array_search($_POST['path'], $_SESSION['favPhotos']);
    if ($location !== false) {
        unset($_SESSION['favPhotos'][$location]);
        $_SESSION['favPhotos'] = array_values($_SESSION['favPhotos']);
        header("Location: favorites.php");
    }
}
?>