<?php
// Database configuration
$host = "rusiann7.helioho.st";
$user = "rusiann7_rusiannn";
$password = "4&3dx10Wl";
$dbname = "rusiann7_evaluation";

// Create connection
try {
    $conn = new mysqli($host, $user, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8");
    
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Data Viewer</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            padding: 30px 0;
            color: white;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .tables-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }
        
        .table-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 20px;
            width: 100%;
            margin-bottom: 20px;
            overflow-x: auto;
        }
        
        h2 {
            color: #2575fc;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
            color: #2575fc;
            font-weight: 600;
        }
        
        tr:hover {
            background-color: #f5f7ff;
        }
        
        .status {
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .success {
            color: #28a745;
            font-weight: 600;
        }
        
        .error {
            color: #dc3545;
            font-weight: 600;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: white;
            margin-top: 40px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .tables-container {
                flex-direction: column;
            }
            
            .table-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Database Data Viewer</h1>
            <p class="subtitle">Displaying contents of Headers and Questions tables</p>
        </header>
        
        <div class="status">
            <?php
            if ($conn->connect_error) {
                echo '<p class="error">Connection failed: ' . $conn->connect_error . '</p>';
            } else {
                echo '<p class="success">Connected successfully to the database</p>';
            }
            ?>
        </div>
        
        <div class="tables-container">
            <div class="table-section">
                <h2>Headers Table</h2>
                <?php
                // Query Headers table
                $headers_sql = "SELECT * FROM Headers";
                $headers_result = $conn->query($headers_sql);
                
                if ($headers_result && $headers_result->num_rows > 0) {
                    echo '<table>';
                    echo '<tr>';
                    // Get column names
                    while ($field = $headers_result->fetch_field()) {
                        echo '<th>' . htmlspecialchars($field->name) . '</th>';
                    }
                    echo '</tr>';
                    
                    // Output data of each row
                    while($row = $headers_result->fetch_assoc()) {
                        echo '<tr>';
                        foreach($row as $value) {
                            echo '<td>' . htmlspecialchars($value) . '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<p>No data found in Headers table</p>';
                }
                ?>
            </div>
            
            <div class="table-section">
                <h2>Questions Table</h2>
                <?php
                // Query Questions table
                $questions_sql = "SELECT * FROM Questions";
                $questions_result = $conn->query($questions_sql);
                
                if ($questions_result && $questions_result->num_rows > 0) {
                    echo '<table>';
                    echo '<tr>';
                    // Get column names
                    while ($field = $questions_result->fetch_field()) {
                        echo '<th>' . htmlspecialchars($field->name) . '</th>';
                    }
                    echo '</tr>';
                    
                    // Output data of each row
                    while($row = $questions_result->fetch_assoc()) {
                        echo '<tr>';
                        foreach($row as $value) {
                            echo '<td>' . htmlspecialchars($value) . '</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<p>No data found in Questions table</p>';
                }
                
                // Close connection
                $conn->close();
                ?>
            </div>
        </div>
        
        <footer>
            <p>Database: <?php echo $dbname; ?> | Host: <?php echo $host; ?></p>
        </footer>
    </div>
</body>
</html>