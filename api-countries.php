<?php
try {

if (isset($_GET["iso"])) {
    $servername = "localhost";
    $username = "root";
    $password = "";

    $connectStr = "mysqlihost=localhost; dbname=basedata";

    $sql='select * from countries where $_GET["iso"]=ISO';
} else {
    $sql = "select * from countries";
}

}
catch() {
    echo "Fuck this";
}

?>
