<?php
require "header-2.php";
require "includes/dbh.inc.php";
?>

<main style="background-color: lightslategray">
    <div id="favList">
        <?php
        if(!empty($_SESSION)){
                if (isset($_SESSION['favPhotos'])) {
                    if (sizeof($_SESSION['favPhotos']) > 0) {

                        echo '<div id="favoriteHeader">';
                        echo '<h1>Favorite Photos</h1>';
                        echo '<form action="" method="post">';
                        echo '<input class="btn" type="submit" name="removeAll" value="Remove ALL from Favorites">';
                        echo '</form>';
                        echo '</div>';
                        foreach ($_SESSION['favPhotos'] as $i) {

                            if ($conn->connect_error) {
                                exit('Error connecting to the database');
                            }

                            $sql = "SELECT * FROM imagedetails WHERE Path=?";
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
                            echo '<div class = "favoriteItem">';
                            echo '<div id = "favoritePhoto"><a href="single-photo.php?ImageID=' . $id['ImageID'] . '">';
                            $img = '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/small320/' . $i . '">';
                            echo $img;
                            echo '</a></div>';
                            echo '<div id="favoritePhotoTitle"><h5>' . $id['Title'] . '</h5></div><div id="removeButton">';
                            createRemove($i);
                            echo '</div></div>';
                        }
                    } else {
                        echo '<h1>No Favorites Saved</h1>';
                    }
                }else{
                    echo '<h1>No Favorites Saved</h1>';
                }
            }
            else{
            echo '<h1>Not Logged In</h1>';
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
    echo '<input class="btn" type="submit" name="remove" value="Remove from Favorites">';
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

if (isset($_POST['removeAll'])) {
    $_SESSION['favPhotos'] = [];
    header("Location: favorites.php");
}
?>