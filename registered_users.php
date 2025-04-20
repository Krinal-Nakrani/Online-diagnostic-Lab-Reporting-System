<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'aarush_clinical';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users
$sql = "SELECT id, full_name, username, email FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f7f8;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        /* Alternating row colors */
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:nth-child(even) {
            background-color: #eaeaea;
        }

        /* Hover effect */
        tbody tr:hover {
            background-color: #d0e2ff;
            transition: 0.3s;
        }

        /* Styling for the prescription link */
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>List of Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full name</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
