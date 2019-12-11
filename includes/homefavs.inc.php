<div>
    <p>Favourites</p>
    <div id="favGrid">
        <?php
        if (isset($_SESSION['favPhotos'])) {
            foreach ($_SESSION['favPhotos'] as $i) {
                $img = '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/' . $i . '">';
                echo $img;
            }
        }
        ?>
    </div>
</div>