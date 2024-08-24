<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$subjects = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = trim($_POST['student_id']);

    // Prepare the SQL statement
    $sql = "SELECT subject_code, subject_name, units FROM regular_students WHERE TRIM(student_id) = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regular Student Registration</title>
    <style>
        /* CSS code provided by the user */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #333333, #666666);
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #222;
            color: #fff;
        }

        header .logo {
            display: flex;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .homepage-btn {
            background-color: #aaaaaa;
            color: #000;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .homepage-btn:hover {
            background-color: #888888;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-container {
            background-color: #444444;
            padding: 30px;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            text-align: left;
            margin-top: 60px;
            margin-bottom: 40px;
        }

        h2 {
            color: #ffffff;
            border-bottom: 2px solid #888888;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            color: #ffffff;
            margin-bottom: 9px;
        }

        .form-group input {
            width: calc(100% - 22px);
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #888888;
            background-color: #333333;
            color: #ffffff;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #aaaaaa;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #888888;
        }

        footer {
            background-color: #222;
            color: #fff;
            padding: 10px 0;
            font-size: 0.9rem;
            position: relative;
            bottom: 0;
            width: 100%;
            text-align: center;
            margin-top: auto;
        }

        #generated-subjects table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: left;
        }

        #generated-subjects th, #generated-subjects td {
            padding: 12px;
            border-bottom: 1px solid #888888;
        }

        #generated-subjects th {
            background-color: #555555;
            color: #ffffff;
        }

        #generated-subjects tr:hover {
            background-color: #333333;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Regular Student Registration</h1>
        </div>
        <button class="homepage-btn" onclick="window.location.href='Homepage.html'">Homepage</button>
    </header>

    <main>
        <div class="form-container">
            <h2>Search Student</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="student-id">Student ID:</label>
                    <input type="text" id="student-id" name="student_id" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-btn">Search</button>
                </div>
            </form>

            <h2>Generated Subjects</h2>
            <div id="generated-subjects">
                <?php if (!empty($subjects)): ?>
                    <table>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Units</th>
                        </tr>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><?= htmlspecialchars($subject['subject_code']) ?></td>
                                <td><?= htmlspecialchars($subject['subject_name']) ?></td>
                                <td><?= htmlspecialchars($subject['units']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No subjects found for this student ID.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>All rights reserved. 2024 unregistered</p>
    </footer>
</body>
</html>
