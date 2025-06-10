<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweetwater Code Project</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Sweetwater PHP Demo App</h1>
        <ul>
            <?php
            // Establish connection.
            $conn = new mysqli("localhost", "root", "", "sweetwaterdemo");

            //Grab all our rows off our table for parsing.
            $result = $conn->query("SELECT * FROM sweetwater_test");

            //Some empty arrays for each type of comment we want
            $candyResults = [];
            $callBackResults = [];
            $referralResults = [];
            $signatureResults = [];
            $remainingResults = [];
            $keyPhrase = 'Expected Ship Date: ';

            //While Loop to do some checks for values within the comments column of each row.
            while ($row = $result->fetch_assoc()) {
                if (str_contains($row['comments'], 'candy')) {
                    array_push($candyResults, $row['comments']);
                } elseif (str_contains($row['comments'], 'call me')) {
                    array_push($callBackResults, $row['comments']);
                } elseif (str_contains($row['comments'], 'dont call me')) {
                    array_push($callBackResults, $row['comments']);
                } elseif (str_contains($row['comments'], 'referred')) {
                    array_push($referralResults, $row['comments']);
                } elseif (str_contains($row['comments'], 'signature')) {
                    array_push($signatureResults, $row['comments']);
                } else {
                    array_push($remainingResults, $row['comments']);
                }

                //Check to see if the customer left a comment containing an expected shipping date. 
                //We want to grab that, parse it out, and update our row with the date for the related column.
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

            //Echos for each array of results.
            echoArrayValues($candyResults, "Candy");
            echoArrayValues($callBackResults, "Calls");
            echoArrayValues($referralResults, "Referrals");
            echoArrayValues($signatureResults, "Signatures");
            echoArrayValues($remainingResults, "Everything Else");

            $conn->close();

            //Function to echo all our values from our arrays without taking up so much space.
            function echoArrayValues($array, $title)
            {
                echo "<h3>Comments About ", $title, "!</h3><br>\n<br>\n";
                foreach ($array as $key => $value) {
                    echo "<li>". $value . "</li><br>\n";
                }
                echo "<br>\n<br>\n";
            }

            ?>
        </ul>
    </div>
</body>

</html>