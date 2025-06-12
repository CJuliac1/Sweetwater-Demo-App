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
        <form action="update_dates.php" method="POST">
            <button type="submit">Update Shipping Dates</button>
        </form>
        <ul>
            <?php
            //Establish connection.
            $conn = new mysqli("localhost", "root", "", "sweetwaterdemo");

            //Grab all our rows off our table for parsing.
            $result = $conn->query("SELECT * FROM sweetwater_test");

            //Names for the sections we want to build.
            $sectionNames = array("Candy", "Calls", "Referrals", "Signatures", "Everything Else");

            //Run our row result through our processing function.
            $processedComments = processCommentsIntoBins($result);

            //Echos for each array of results.
            foreach ($processedComments as $index => $commentBin) {
                echoArrayValues($commentBin, $sectionNames[$index]);
            }

            //Close our connection.
            $conn->close();

            //Function to echo all our values from our arrays without taking up so much space.
            function echoArrayValues($array, $title)
            {
                echo "<h3>Comments About ", $title, "!</h3><br>\n<br>\n";
                foreach ($array as $key => $value) {
                    echo "<li>" . $value . "</li><br>\n";
                }
                echo "<br>\n<br>\n";
            }

            //Function to take all our comment data and turn them into processed bins. 
            //Returns a 2d Array of the bins for use in building our tables of comments.
            function processCommentsIntoBins($result): array
            {
                //Some empty arrays for each type of comment we want.
                //To update: add a new bin, and update the while loop.
                $candyResults = [];
                $callBackResults = [];
                $referralResults = [];
                $signatureResults = [];
                $remainingResults = [];

                //Itterative loop to take our results and push them into the correct bins.
                while ($row = $result->fetch_assoc()) {
                    if (str_contains($row['comments'], 'candy')) {
                        array_push($candyResults, $row['comments']);
                    } elseif (str_containsTwo($row['comments'], ['call me', 'dont call me'])) {
                        array_push($callBackResults, $row['comments']);
                    } elseif (str_contains($row['comments'], 'referred')) {
                        array_push($referralResults, $row['comments']);
                    } elseif (str_contains($row['comments'], 'signature')) {
                        array_push($signatureResults, $row['comments']);
                    } else {
                        array_push($remainingResults, $row['comments']);
                    }
                }

                //Return an array of our bins.
                return [$candyResults, $callBackResults, $referralResults, $signatureResults, $remainingResults];
            }

            //Function to help us out when we need to search a "haystack" for two or more "needles".
            function str_containsTwo(string $haystack, array $needles)
            {
                //For every needle, check if its somewhere in that darn haystack. As currently implemented, operates as an OR statement. 
                foreach ($needles as $needle) {
                    if (str_contains($haystack, $needle)) {
                        return true;
                    }
                }
                return false;
            }
            ?>
        </ul>
    </div>
</body>

</html>