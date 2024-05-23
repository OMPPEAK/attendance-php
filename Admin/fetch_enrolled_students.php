<?php
include '../Includes/dbcon.php';

// Directory containing the files
$directory = '../futronic/DataBaseNet';
$files = array_diff(scandir($directory), array('.', '..'));

// Strip file extensions from the filenames
$filesWithoutExtension = array_map(function($file) {
    return pathinfo($file, PATHINFO_FILENAME);
}, $files);

// Get all students from the database
$sql = "SELECT admissionNumber, firstName, lastName FROM tblstudents";
$result = $conn->query($sql);

$enrolledStudents = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (in_array($row['admissionNumber'], $filesWithoutExtension)) {
            $enrolledStudents[] = [
                'admissionNumber' => $row['admissionNumber'],
                'fullName' => $row['firstName'] . ' ' . $row['lastName']
            ];
        }
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($enrolledStudents);
?>
