<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../img/logo/attnlg.PNG" rel="icon">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <title>Enrolled Students</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .enrolled {
            color: green;
            font-weight: bold;
        }
        .not-enrolled {
            color: red;
        }
    </style>
    <script>
        function fetchEnrolledStudents() {
            $.ajax({
                url: 'fetch_enrolled_students.php',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
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
                error: function () {
                    console.error('Failed to fetch data');
                }
            });
        }

        $(document).ready(function () {
            fetchEnrolledStudents(); // Fetch initially
            setInterval(fetchEnrolledStudents, 2000); // Fetch every 2 seconds
        });
    </script>
</head>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php";?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include "Includes/topbar.php";?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Students Enrolled with Fingerprint</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Enrolled Students</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Enrolled Students</h6>
                                    <?php //echo $statusMsg; ?>
                                </div>
                                <!-- Input Group -->
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


                            </div>


                        </div>

                        <!-- Scroll to top -->
                        <a class="scroll-to-top rounded" href="#page-top">
                            <i class="fas fa-angle-up"></i>
                        </a>


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
                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js">
                        </script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js">
                        </script>

                        <script src="../vendor/jquery/jquery.min.js"></script>
                        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
                        <script src="js/ruang-admin.min.js"></script>
                        <!-- Page level plugins -->
                        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
                        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>


</body>

</html>