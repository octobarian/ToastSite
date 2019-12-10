<?php 

require 'includes/dbh.inc.php';

//--------IMAGE FETCH-----------------------------------------------------------

if($conn->connect_error){
    exit('Error connecting to the database');
}


$sql ="SELECT * FROM imagedetails";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: index.php?error=sqlerror");
    exit();
}
else{

        mysqli_stmt_prepare($stmt, $sql);

    

    mysqli_stmt_execute($stmt);
    $image = mysqli_stmt_get_result($stmt);
    $imageRow = mysqli_fetch_assoc($image);
}
mysqli_stmt_close($stmt);


//--------COUNTRY FETCH-----------------------------------------------------------

$countrySQL = "SELECT * FROM countries WHERE ISO IN (SELECT CountryCodeISO FROM imagedetails)";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $countrySQL)){
    header("Location: index.php?error=sqlerror");
    exit();
}
else{
    
    mysqli_stmt_prepare($stmt, $countrySQL);
        //Finds "s"<string> and replaces it with variable $id

    mysqli_stmt_execute($stmt);
    $country = mysqli_stmt_get_result($stmt);
    
}
mysqli_stmt_close($stmt);


//--------CITY FETCH-----------------------------------------------------------

$citySQL = "SELECT * FROM cities WHERE CityCode IN (SELECT CityCode FROM imagedetails)";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $citySQL)){
    header("Location: index.php?error=sqlerror");
    exit();
}
else{
    
    mysqli_stmt_prepare($stmt, $citySQL);
    
    mysqli_stmt_execute($stmt);
    $city = mysqli_stmt_get_result($stmt);
    
}
mysqli_stmt_close($stmt);

require "header.php";
?>
<link rel="stylesheet" type="text/css" href="css/photo-browser.css">
<main>
    <div id="container">
        <div id="photoCountryFilter">
            <!--Search photos by title-->
            <?php include 'includes/homesearch.inc.php'?>
            <!--Search photos by country-->
            <form action="photo-browser.php" method="get">
                <select name="countryISO" id="photoCountrySelect">
                    <?php
           //https://riptutorial.com/php/example/9382/loop-through-mysqli-results
         
                while($row = mysqli_fetch_assoc($country)){
                    $value = $row['ISO' ];
                    $countryName = $row['CountryName'];
                    echo '<option value="' . $value . '">' . $countryName . '</option>';
                    
                }
            ?>

                </select>
                <button type="submit" value="Search Country">Search Country</button>
            </form>
            <!--Search photos by city-->
            <form action="photo-browser.php" method="get">
                <select name="cityCode" id="photoCitySelect">
                    <?php
        
                while($row = mysqli_fetch_assoc($city)){
                    $value = $row['CityCode'];
                    $cityName = $row['AsciiName'];
                    echo '<option value="' . $value . '">' . $cityName . '</option>';
                   
                }
            ?>

                </select>
                <button type="submit" value="Search City">Search City</button>
            </form>
        </div>


        <div id="browsesearchResult">

            <?php
                if(!isset($_GET['countryISO'])&&!isset($_GET['cityCode'])&&!isset($_GET['titleSearch'])){
                    echo '<div class="bodyTitle"><h1>Browse Photos or Search Photos</h1></div>';
                    echo '<div id="resultGrid">';
                    while ($row = mysqli_fetch_assoc($image)){
                        echo '<div class="imageBox"><a href="single-photo.php?ImageID=' .$row['ImageID'] . '">';
                        echo '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/' . $row['Path'] . '" />';
                        echo '</a></div>';
                    }
                    echo '</div>';
                }
                if(isset($_GET['countryISO'])){ //If searching by country
                    $countryPostValue = $_GET['countryISO'];
                    $isCountry = 1;
//------FETCH PHOTOS THAT MATCHES CLICKED COUNTRY---------------------------------
                    $findPhotoSQL = "SELECT * FROM imagedetails WHERE CountryCodeISO = ? ORDER BY Title";
                    $searchedImage = photoSQLSearch($findPhotoSQL, $conn, $countryPostValue);
                    displayPhotos($searchedImage, $isCountry, $countryPostValue);
        
                }elseif(isset($_GET['cityCode'])){ //If searching by city
                    $cityPostValue = $_GET['cityCode'];
                    $isCountry = 0;

    //-----FETCH PHOTOS THAT MATCHES CLICKED CITY---------------------------------
                    $findPhotoSQL = "SELECT * FROM imagedetails WHERE CityCode = ? ORDER BY Title";
                    $searchedImage = photoSQLSearch($findPhotoSQL, $conn, $cityPostValue);
                    displayPhotos($searchedImage, $isCountry, $cityPostValue);
    
                }elseif (isset($_GET['titleSearch'])){
                    $titleValue = $_GET['titleSearch'];
                    $isCountry = 2;
                    if ($titleValue == ""){
                        echo '<div class="bodyTitle"><h1>Field is blank. Search for photo</h1></div>';
                    }else{  
    //---------FETCH PHOTOS THAT MATCHES TITLE--------------------------------
    //https://dba.stackexchange.com/questions/203206/find-if-any-of-the-rows-partially-match-a-string
                        $findPhotoSQL = "SELECT * FROM imagedetails WHERE Title LIKE CONCAT('%', ? , '%') ORDER BY Title";
                        $searchedImage = photoSQLSearch($findPhotoSQL, $conn, $titleValue);
                        displayPhotos($searchedImage, $isCountry, $titleValue);
                    }
                }else{
                    
                }
                

                function displayPhotos($searchedImage, $isCountry, $searchValue){
                    echo '<div class="bodyTitle"><h1>Search Result</h1></div>';
                    echo '<div id="resultRow">';
                   
                    while ($row = mysqli_fetch_assoc($searchedImage)){
                        echo '<div class="imageBox">';
                        echo '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/' . $row['Path'] . '" />';
                        echo '<div id="photoTitle"><h3>'.$row['Title'].'</h3></div>';
            
                        echo '<div><form id="viewButton" action="single-photo.php" method="get">';
                        echo '<input type="hidden" name="ImageID" value="' . $row['ImageID'] . '">';
                        echo '<button type="submit" name="viewImg" value="View">View Image</button>';
                        echo '</form></div>';

                        echo '<div><form id="favoriteButton" action="photo-browser.php" method="post">';
                        echo '<input type="hidden" name="path" value="' . $row['Path']. '">';
                        if ($isCountry == 1){
                            echo '<input type="hidden" name="countrySearch" value="' . $searchValue . '">';
                        }elseif ($isCountry == 0){
                            echo '<input type="hidden" name="citySearch" value="' . $searchValue . '">';
                        }elseif ($isCountry == 2){
                            echo '<input type="hidden" name="titleSearch value="' . $searchValue . '">';
                        } 
                        echo '<button type="submit" name="fav" value="Add to Favorites">Add to Favorites</button>';
                        echo '</form></div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
                
                function photoSQLSearch($sql, $conn, $searchValue){
                    $findPhotoSQL = $sql;
                    $stmt = mysqli_stmt_init($conn);                    
    
                    if(!mysqli_stmt_prepare($stmt, $findPhotoSQL)){
                        header("Location: index.php?error=sqlerror");
                        exit();
                    }else{
                        mysqli_stmt_prepare($stmt, $findPhotoSQL);
                        mysqli_stmt_bind_param($stmt, "s", $searchValue);
                        mysqli_stmt_execute($stmt);
                        $searchedImage = mysqli_stmt_get_result($stmt);
                    }
                        mysqli_stmt_close($stmt);        
                        return $searchedImage;
                }   

  ?>
        </div>

</main>

<?php

     if (isset($_POST['fav'])) {
        if (isset($_SESSION['favPhotos'])) {
            array_push($_SESSION['favPhotos'], $_POST['path']);
        } else {
           
            $_SESSION['favPhotos'] = array($_POST['path']);
        }
    }
   
?>

<?php
    require "footer.php";
    mysqli_close($conn);
?>