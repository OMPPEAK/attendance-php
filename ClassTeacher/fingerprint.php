<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollment List</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .enrolled {
            color: green;
            font-weight: bold;
        }
        .not-enrolled {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Student Enrollment List</h1>
        <button id="export-button" class="btn btn-primary mb-3">Export to Excel</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Full Name</th>
                    <th>Matric Number</th>
                    <th>Fingerprint Status</th>
                </tr>
            </thead>
            <tbody id="student-list"></tbody>
        </table>
    </div>

    <script>
        function fetchStudents() {
            fetch('get_files.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data); // Debugging statement
                    const studentList = document.getElementById('student-list');
                    studentList.innerHTML = '';
                    data.forEach((student, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${student.firstName}</td>
                            <td>${student.admissionNumber}</td>
                            <td class="${student.enrolled ? 'enrolled' : 'not-enrolled'}">
                                ${student.enrolled ? 'Enrolled' : 'Not Enrolled'}
                            </td>
                        `;
                        studentList.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching students:', error));
        }

        // Fetch students every 5 seconds
        setInterval(fetchStudents, 5000);

        // Initial fetch
        fetchStudents();

        document.getElementById('export-button').addEventListener('click', () => {
            // window.location.href = 'export_to_excel.php';
            window.location.href = 'export_to_excel.php';
        });
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
