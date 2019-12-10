<?php 

require 'includes/dbh.inc.php';

//--------IMAGE FETCH-----------------------------------------------------------

if($conn->connect_error){
    exit('Error connecting to the database');
}


$sql ="SELECT * FROM imagedetails";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: ../index.php?error=sqlerror");
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
    header("Location: ../index.php?error=sqlerror");
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
    header("Location: ../index.php?error=sqlerror");
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

<main>
    <div id="photoCountryFilter">
        <!--Search photos by title-->
        <?php include 'includes/photo-search.inc.php'?>
        <!--Search photos by country-->
        <form action="/COMP-3512-A2/photo-browser.php" method="post">
            <select name="countrySearch" id="photoCountrySelect">
                <?php
           //https://riptutorial.com/php/example/9382/loop-through-mysqli-results
         
                while($row = mysqli_fetch_assoc($country)){
                    $value = $row['ISO' ];
                    $countryName = $row['CountryName'];
                    echo '<option value="' . $value . '">' . $countryName . '</option>';
                    
                }
            ?>

            </select>
            <input type="submit" value="Search Country">
        </form>
        <!--Search photos by city-->
        <form action="/COMP-3512-A2/photo-browser.php" method="post">
            <select name="citySearch" id="photoCitySelect">
                <?php
        
                while($row = mysqli_fetch_assoc($city)){
                    $value = $row['CityCode' ];
                    $cityName = $row['AsciiName'];
                    echo '<option value="' . $value . '">' . $cityName . '</option>';
                   
                }
            ?>

            </select>
            <input type="submit" value="Search City">
        </form>
    </div>

    <div id="browse/searchResult">
        <?php
        if(isset($_POST['countrySearch'])){ //If searching by country
            $countryPostValue = $_POST['countrySearch'];
            $isCountry = 1;
//------FETCH PHOTOS THAT MATCHES CLICKED COUNTRY---------------------------------

        $findPhotoSQL = "SELECT * FROM imagedetails WHERE CountryCodeISO = ? ORDER BY Title";

        $stmt = mysqli_stmt_init($conn);                    
        
    if(!mysqli_stmt_prepare($stmt, $findPhotoSQL)){
        header("Location: ../index.php?error=sqlerror");
        exit();
    }else{

        mysqli_stmt_prepare($stmt, $findPhotoSQL);
        mysqli_stmt_bind_param($stmt, "s", $countryPostValue);
        mysqli_stmt_execute($stmt);
        $searchedImage = mysqli_stmt_get_result($stmt);
        
    }
    mysqli_stmt_close($stmt);
//-----------FETCH END--------------------------------------------------------------
    
    displayPhotos($searchedImage, $isCountry, $countryPostValue);
        
        }elseif(isset($_POST['citySearch'])){ //If searching by city
            $cityPostValue = $_POST['citySearch'];
            $isCountry = 0;

    //-----FETCH PHOTOS THAT MATCHES CLICKED CITY---------------------------------
    $findPhotoSQL = "SELECT * FROM imagedetails WHERE CityCode = ? ORDER BY Title";

    $stmt = mysqli_stmt_init($conn);                    
    
    if(!mysqli_stmt_prepare($stmt, $findPhotoSQL)){
        header("Location: ../index.php?error=sqlerror");
    exit();
    }else{

    mysqli_stmt_prepare($stmt, $findPhotoSQL);
    mysqli_stmt_bind_param($stmt, "i", $cityPostValue);
    mysqli_stmt_execute($stmt);
    $searchedImage = mysqli_stmt_get_result($stmt);
    
    }
        mysqli_stmt_close($stmt);        
//------FETCH END-------------------------------------------------------
    
    displayPhotos($searchedImage, $isCountry, $cityPostValue);
    
}elseif (isset($_POST['titleSearch'])){
      $titleValue = $_POST['titleSearch'];
        $isCountry = 2;
     if ($titleValue == ""){
         echo '<h1>Field is blank. Search for photo</h1>';
     }else{  
    //---------FETCH PHOTOS THAT MATCHES TITLE--------------------------------
    //https://dba.stackexchange.com/questions/203206/find-if-any-of-the-rows-partially-match-a-string
    $findPhotoSQL = "SELECT * FROM imagedetails WHERE Title LIKE CONCAT('%', ? , '%') ORDER BY Title";

    $stmt = mysqli_stmt_init($conn);                    
    
    if(!mysqli_stmt_prepare($stmt, $findPhotoSQL)){
        header("Location: ../index.php?error=sqlerror");
    exit();
    }else{

    mysqli_stmt_prepare($stmt, $findPhotoSQL);
    mysqli_stmt_bind_param($stmt, "s", $titleValue);
    mysqli_stmt_execute($stmt);
    $searchedImage = mysqli_stmt_get_result($stmt);
    
    }
        mysqli_stmt_close($stmt);        
//------FETCH END------------------------------------------------------- 
      displayPhotos($searchedImage, $isCountry, $titleValue);
      }
    }else{
          echo  '<h1> Please search for photos by title, country, or city! </h1>';
    }


    function displayPhotos($searchedImage, $isCountry, $searchValue){
        echo '<h1>Search Result</h1>';
        while ($row = mysqli_fetch_assoc($searchedImage)){
            echo '<div>';
            echo '<img src="https://storage.googleapis.com/riley_comp3512_ass1_images/case-travel-master/images/square150/' . $row['Path'] . '" />';
            echo $row['Title'];
            
            echo '<form action="/COMP-3512-A2/single-photo.php" method="get">';
            echo '<input type="hidden" name="ImageID" value="' . $row['ImageID'] . '">';
            echo '<input type="submit" name="viewImg" value="View">';
            echo '</form>';

            echo '<form action="/COMP-3512-A2/photo-browser.php" method="post">';
            echo '<input type="hidden" name="path" value="' . $row['Path']. '">';
            if ($isCountry == 1){
                echo '<input type="hidden" name="countrySearch" value="' . $searchValue . '">';
            }
            elseif ($isCountry == 0){
                echo '<input type="hidden" name="citySearch" value="' . $searchValue . '">';
            }elseif ($isCountry == 2){
                echo '<input type="hidden" name="titleSearch value="' . $searchValue . '">';
            } 
            echo '<input type="submit" name="fav" value="Add to Favorites">';
            echo '</form>';
            //Put add to favorite
            echo '</div>';
        }
    }

  ?>
    </div>

</main>

<?php

     if (isset($_POST['fav'])) {
        if (isset($_SESSION['favPhotos'])) {
        
            array_push($_SESSION['favPhotos'], $_POST['Path']);
            
        } else {
           
            $_SESSION['favPhotos'] = array($_POST['Path']);
        }
    }
   
?>

<?php
    require "footer.php";
    mysqli_close($conn);
?>