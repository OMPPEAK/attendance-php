<?php
include 'Includes/dbcon.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

// Directory containing the files
$directory = './futronic/DataBaseNet';
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

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the header row
$sheet->setCellValue('A1', 'S/N');
$sheet->setCellValue('B1', 'Full Name');
$sheet->setCellValue('C1', 'Matric Number');
$sheet->setCellValue('D1', 'Fingerprint Status');

// Populate the spreadsheet with student data
$rowNumber = 2;
foreach ($students as $index => $student) {
    $sheet->setCellValue('A' . $rowNumber, $index + 1);
    $sheet->setCellValue('B' . $rowNumber, $student['firstName']);
    $sheet->setCellValue('C' . $rowNumber, $student['admissionNumber']);
    $sheet->setCellValue('D' . $rowNumber, $student['enrolled'] ? 'Enrolled' : 'Not Enrolled');
    $rowNumber++;
}

// Set the file properties
$spreadsheet->getProperties()
    ->setCreator("Your Name")
    ->setTitle("Student Enrollment List")
    ->setDescription("List of student enrollments.");

// Output the file to the browser for download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="student_enrollment_list.xls"');
header('Cache-Control: max-age=0');

$writer = new Xls($spreadsheet);
$writer->save('php://output');
exit();
?>
