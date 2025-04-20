<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hospital_admin");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];

// Fetch all tests for the logged-in user
$sql = "SELECT DISTINCT test FROM tracking WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$tests = [];

while ($row = $result->fetch_assoc()) {
    $tests[] = $row['test'];
}

$stmt->close();

// Get selected test from URL or first test by default
$selected_test = isset($_GET['test']) ? $_GET['test'] : (count($tests) > 0 ? $tests[0] : null);

if ($selected_test) {
    // Fetch the latest tracking status for the selected test
    $sql = "SELECT update_status FROM tracking WHERE username = ? AND test = ? ORDER BY time_date DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $selected_test);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    $statuses = [
        1 => "Sample Collected",
        2 => "Sample Processing",
        3 => "Process Completed",
        4 => "Generating Reports",
        5 => "Reports Delivered"
    ];
    
    $current_step = $result->num_rows > 0 ? $result->fetch_assoc()['update_status'] : 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track My Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        .tracking-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 50px auto;
            width: 80%;
            position: relative;
        }
        .step {
            text-align: center;
            flex: 1;
        }
        .step .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #ddd;
            line-height: 50px;
            font-size: 18px;
            color: #555;
            margin: 0 auto 10px;
            display: inline-block;
        }
        .step.active .circle {
            background-color: #4CAF50;
            color: white;
        }
        .step .label {
            font-size: 14px;
            color: #555;
        }
        .line {
            position: absolute;
            top: 25px;
            left: 0;
            right: 0;
            height: 5px;
            background-color: #ddd;
            z-index: -1;
        }
        .line.active {
            background-color: #4CAF50;
        }
    </style>
</head>

<body>

    <h2>Track My Test</h2>

    <?php if (count($tests) > 0) : ?>
        <label for="testSelect">Select Test:</label>
        <select id="testSelect" onchange="changeTest()">
            <?php foreach ($tests as $test) : ?>
                <option value="<?= htmlspecialchars($test) ?>" <?= ($test === $selected_test) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($test) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="tracking-container">
            <div class="line <?= $current_step > 1 ? 'active' : '' ?>"></div>

            <?php foreach ($statuses as $step => $status) : ?>
                <div class="step <?= $step <= $current_step ? 'active' : '' ?>">
                    <div class="circle"><?= $step ?></div>
                    <div class="label"><?= htmlspecialchars($status) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else : ?>
        <p style="color: red;">No tests found for tracking.</p>
    <?php endif; ?>

    <script>
        function changeTest() {
            const selectedTest = document.getElementById("testSelect").value;
            window.location.href = "track_my_test.php?test=" + encodeURIComponent(selectedTest);
        }
    </script>

</body>

</html>
