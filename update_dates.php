<?php
//Establish connection.
$conn = new mysqli("localhost", "root", "", "sweetwaterdemo");

//Grab all our rows off our table for parsing.
$result = $conn->query("SELECT * FROM sweetwater_test");

//Our magic words to get our date
$keyPhrase = 'Expected Ship Date: ';

//Check to see if the customer left a comment containing an expected shipping date. 
//We want to grab that, parse it out, and update our row with the date for the related column.
while ($row = $result->fetch_assoc()) {
    if (str_contains($row['comments'], $keyPhrase)) {
        //Find where our magic string is, and preserve that location.
        $startingPoint = strpos($row['comments'], $keyPhrase);
        //Get our date Substring based on the index we found above, and then the length of our hey phrase.
        $dateString = strtotime(substr($row['comments'], $startingPoint + strlen($keyPhrase)));
        $formattedDate = date('Y-m-d', $dateString);
        //Make our update statement and set the shipping date to our nice date string where order ids match.
        $sql = "UPDATE sweetwater_test SET shipdate_expected = '$formattedDate' WHERE orderid = '$row[orderid]'";
        $conn->query($sql);
    }
}

//Close our connection
$conn->close();

// Redirect back to the main page
header("Location: index.php");
exit();
?>