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
        <h1>DB Connection Test</h1>
        <ul>
            <?php
            // Retrieve all comments just to make sure we can 
            $conn = new mysqli("localhost", "root", "", "sweetwaterdemo");
            // $result = $conn->query("SELECT * FROM sweetwater_test");
            $candyComments = $conn->query(query:"SELECT * from sweetwater_test where comments like '%candy%'");

            while ($row = $candyComments->fetch_assoc()){
                echo "<li>" . $row['comments'];
            }
            // while ($row = $result->fetch_assoc()) {
            //     echo "<li>" . $row['orderid'];
            // }

            $conn->close();
            ?>
        </ul>
    </div>
</body>
</html>