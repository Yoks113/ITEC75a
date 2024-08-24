<?php
// Database connection
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

// SQL query to fetch all student records
$sql = "SELECT * FROM new_students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="NStudent_styles.css">
    <style>
        .print-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #3e8e41;
        }
        .center-btn {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>Student List</h1>
        </div>
        <button class="homepage-btn" onclick="window.location.href='Homepage.html'">Homepage</button>
    </header>

    <main>
        <div class="form-container">
            <h2>Registered Students</h2>
            <div class="table-container">
                <table id="student-table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Middle Initial</th>
                            <th>Last Name</th>
                            <th>Birthdate</th>
                            <th>Gender</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Emergency Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['first_name']}</td>
                                        <td>{$row['middle_initial']}</td>
                                        <td>{$row['last_name']}</td>
                                        <td>{$row['birth_month']}/{$row['birth_day']}/{$row['birth_year']}</td>
                                        <td>{$row['gender']}</td>
                                        <td>{$row['phone_number']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['house_number']} {$row['lot_number']}, {$row['subdivision']}, {$row['city']}, {$row['province']} {$row['postal_code']}</td>
                                        <td>{$row['emergency_name']} ({$row['relationship']}): {$row['emergency_contact']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No students found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="center-btn">
                    <button class="print-btn" onclick="printTable()">Print Student List</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>All rights reserved. 2024 unregistered</p>
    </footer>

    <script>
        function printTable() {
            var table = document.getElementById('student-table');
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Student List</title></head><body>');
            printWindow.document.write(table.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.print();
            printWindow.close();
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>