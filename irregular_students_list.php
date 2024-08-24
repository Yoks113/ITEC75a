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

// SQL query to fetch all irregular student records
$sql = "SELECT * FROM irregular_students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Irregular Student List</title>
    <link rel="stylesheet" href="Irregular_styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>Irregular Student List</h1>
        </div>
        <button class="homepage-btn" onclick="window.location.href='Homepage.html'">Homepage</button>
    </header>

    <main>
        <div class="form-container">
            <h2>Irregular Students</h2>
            <div class="table-container">
                <table id="irregular-student-table">
                    <thead>
                        <tr>
                            <th>Student ID Number</th>
                            <th>Year Level</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Units</th>
                            <th>Schedule</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['student_number']}</td>
                                        <td>{$row['year_level']}</td>
                                        <td>{$row['subject_code']}</td>
                                        <td>{$row['subject_name']}</td>
                                        <td>{$row['units']}</td>
                                        <td>{$row['schedule']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No irregular students found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="center-btn">
                    <button class="print-btn" onclick="printTable()">Print Irregular Student List</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>All rights reserved. 2024 unregistered</p>
    </footer>

    <script>
        function printTable() {
            var table = document.getElementById('irregular-student-table');
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Irregular Student List</title></head><body>');
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