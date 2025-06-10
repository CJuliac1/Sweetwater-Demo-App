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
                echo "Comments About ", $title, "!<br>\n<br>\n";
                foreach ($array as $key => $value) {
                    echo $value . "<br>\n<br>\n";
                }
                echo "<br>\n<br>\n";
            }
            ?>
        </ul>
    </div>
</body>

</html>