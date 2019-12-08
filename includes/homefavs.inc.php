<div>
<p>Favourites</p>
<?php
    if(isset($_SESSION['favPhotos'])){
        foreach($_SESSION['favPhotos'] as $i){
            echo '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/large1024/$i">';
        }
    }
?>
</div>