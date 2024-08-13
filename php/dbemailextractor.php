<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extract Emails from Database</title>
</head>
<body>
    <h1>Extract Emails from Database</h1>
    
    <!-- HTML Form for Database Details -->
    <form method="post" action="">
        <label for="host">Database Host:</label>
        <input type="text" id="host" name="host" required><br><br>

        <label for="username">Database Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Database Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="dbname">Database Name:</label>
        <input type="text" id="dbname" name="dbname" required><br><br>

        <input type="submit" name="submit" value="Extract Emails">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection details from form
        $host = $_POST['host'];
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $dbname = $_POST['dbname'];

        // Connect to the database
        $conn = new mysqli($host, $user, $pass, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Function to check if a string looks like an email
        function is_email($string) {
            return filter_var($string, FILTER_VALIDATE_EMAIL);
        }

        // Get all tables in the database
        $tablesResult = $conn->query("SHOW TABLES");
        $emails = [];

        while ($table = $tablesResult->fetch_array()) {
            $tableName = $table[0];
            
            // Get all columns in the table
            $columnsResult = $conn->query("SHOW COLUMNS FROM `$tableName`");
            
            while ($column = $columnsResult->fetch_array()) {
                $columnName = $column['Field'];
                
                // Query to get potential emails
                $query = "SELECT `$columnName` FROM `$tableName` WHERE `$columnName` LIKE '%@%'";
                $result = $conn->query($query);
                
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $value = $row[$columnName];
                        if (is_email($value)) {
                            $emails[] = $value;
                        }
                    }
                }
            }
        }

        // Remove duplicate emails
        $emails = array_unique($emails);

        // Save the emails to a file
        $file = "output.EMAIL.$dbname.txt";
        $fileHandle = fopen($file, 'w'); // Open file for writing
        if ($fileHandle) {
            foreach ($emails as $email) {
                fwrite($fileHandle, htmlspecialchars($email) . PHP_EOL);
            }
            fclose($fileHandle);
            echo "<p>Emails have been saved to <a href='$file'>$file</a>.</p>";
        } else {
            echo "<p>Failed to create or open the file.</p>";
        }

        // Close the database connection
        $conn->close();
    }
    ?>
</body>
</html>
