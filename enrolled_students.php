<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrolled Students</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function fetchEnrolledStudents() {
            $.ajax({
                url: 'fetch_enrolled_students.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let tableBody = $('#students-table tbody');
                    tableBody.empty(); // Clear the table

                    if (data.length > 0) {
                        data.forEach((student, index) => {
                            tableBody.append(
                                `<tr>
                                    <td>${index + 1}</td>
                                    <td>${student.fullName}</td>
                                    <td>${student.admissionNumber}</td>
                                </tr>`
                            );
                        });
                    } else {
                        tableBody.append('<tr><td colspan="3">No enrolled students found.</td></tr>');
                    }
                },
                error: function() {
                    console.error('Failed to fetch data');
                }
            });
        }

        $(document).ready(function() {
            fetchEnrolledStudents(); // Fetch initially
            setInterval(fetchEnrolledStudents, 2000); // Fetch every 2 seconds
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Enrolled Students</h2>
    <table class="table table-bordered" id="students-table">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Full Name</th>
                <th>Matric Number</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated here by JavaScript -->
        </tbody>
    </table>
</div>
</body>
</html>
