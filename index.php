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

            //Original result for grabbing all rows, might need later.
            // $result = $conn->query("SELECT * FROM sweetwater_test");

            //Super gross super basic query per area of concern IE candy, callbacks, referrals etc.
            $candyComments = $conn->query(query:"SELECT * from sweetwater_test where comments like '%candy%'");
            $callBackComments = $conn->query(query:"SELECT * from sweetwater_test where comments like '%call me%' or comments like '%dont call me%' or comments like '%do not call me%'");
            $referralComments = $conn->query(query:"SELECT * from sweetwater_test where comments like '%referral%' or comments like '%referred%'");
            $signatureComments = $conn->query(query:"SELECT * from sweetwater_test where comments like '%signature%'");
            //Equally simple and choppy while loops to itterate over our results and slap em ina  big gross list for now.
            while ($row = $candyComments->fetch_assoc()){
                echo "<li>" . $row['comments'];
            }
            while($row = $callBackComments->fetch_assoc()){
                echo "<li>". $row['comments'];
            }
            while($row = $referralComments->fetch_assoc()){
                echo "<li>". $row['comments'];
            }
            while($row = $signatureComments->fetch_assoc()){
                echo "<li>". $row['comments'];
            }

            //Old result to print all id's to test
            // while ($row = $result->fetch_assoc()) {
            //     echo "<li>" . $row['orderid'];
            // }

            $conn->close();
            ?>
        </ul>
    </div>
</body>
</html>