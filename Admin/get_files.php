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
$sql = "SELECT admissionNumber, firstName FROM tblstudents";
$result = $conn->query($sql);

$students = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = [
            'admissionNumber' => $row['admissionNumber'],
            'firstName' => $row['firstName'],
            'enrolled' => in_array($row['admissionNumber'], $filesWithoutExtension)
        ];
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($students);
?>
