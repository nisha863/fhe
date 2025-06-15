<<<<<<< HEAD
<?php
header("Content-Type: application/json");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "fhe_db"; // Change to your actual database name


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed."]);
    exit;
}

// Handle file upload for student_picture
$student_picture_path = "";
if (isset($_FILES['student_picture']) && $_FILES['student_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $filename = uniqid() . "_" . basename($_FILES["student_picture"]["name"]);
    $target_file = $upload_dir . $filename;
    if (move_uploaded_file($_FILES["student_picture"]["tmp_name"], $target_file)) {
        $student_picture_path = $target_file;
    }
}

// Get POST data (FormData)
$fullname = $conn->real_escape_string($_POST['fullname'] ?? '');
$id_number = $conn->real_escape_string($_POST['id'] ?? '');
$address = $conn->real_escape_string($_POST['address'] ?? '');
$sex = $conn->real_escape_string($_POST['sex'] ?? '');
$civil_status = $conn->real_escape_string($_POST['civil_status'] ?? '');
$phone = $conn->real_escape_string($_POST['phone'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$course = $conn->real_escape_string($_POST['course'] ?? '');
$year_level = $conn->real_escape_string($_POST['year_level'] ?? '');
$type_student = $conn->real_escape_string($_POST['type_student'] ?? '');
$school_name_last_attended = $conn->real_escape_string($_POST['school_name_last_attended'] ?? '');
$year_last_attended = $conn->real_escape_string($_POST['year_last_attended'] ?? '');
$scholarship = $conn->real_escape_string($_POST['scholarship'] ?? '');
$scholarship_name = $conn->real_escape_string($_POST['scholarship_name'] ?? '');
$mother_name = $conn->real_escape_string($_POST['mother_name'] ?? '');
$father_name = $conn->real_escape_string($_POST['father_name'] ?? '');
$mother_occupation = $conn->real_escape_string($_POST['mother_occupation'] ?? '');
$father_occupation = $conn->real_escape_string($_POST['father_occupation'] ?? '');
$mother_income = $conn->real_escape_string($_POST['mother_income'] ?? '');
$father_income = $conn->real_escape_string($_POST['father_income'] ?? '');
$student_signature = $conn->real_escape_string($_POST['student_signature'] ?? '');
$guardian_signature = $conn->real_escape_string($_POST['guardian_signature'] ?? '');
$guardian_name = $conn->real_escape_string($_POST['guardian_name'] ?? '');
$guardian_relationship = $conn->real_escape_string($_POST['guardian_relationship'] ?? '');
$date_of_application = $conn->real_escape_string($_POST['date_of_application'] ?? '');

// Insert query
$sql = "INSERT INTO students (
    fullname, id_number, address, sex, civil_status, phone, email, course, year_level, type_student,
    school_name_last_attended, year_last_attended, scholarship, scholarship_name,
    mother_name, father_name, mother_occupation, father_occupation, mother_income, father_income,
    student_signature, guardian_signature, guardian_name, guardian_relationship, student_picture, date_of_application
) VALUES (
    '$fullname', '$id_number', '$address', '$sex', '$civil_status', '$phone', '$email', '$course', '$year_level', '$type_student',
    '$school_name_last_attended', '$year_last_attended', '$scholarship', '$scholarship_name',
    '$mother_name', '$father_name', '$mother_occupation', '$father_occupation', '$mother_income', '$father_income',
    '$student_signature', '$guardian_signature', '$guardian_name', '$guardian_relationship', '$student_picture_path', '$date_of_application'
)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Student data saved successfully."]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
=======
<?php
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "your_database_name"; // Change to your actual database name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed."]);
    exit;
}

// Handle file upload for student_picture
$student_picture_path = "";
if (isset($_FILES['student_picture']) && $_FILES['student_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $filename = uniqid() . "_" . basename($_FILES["student_picture"]["name"]);
    $target_file = $upload_dir . $filename;
    if (move_uploaded_file($_FILES["student_picture"]["tmp_name"], $target_file)) {
        $student_picture_path = $target_file;
    }
}

// Get POST data (FormData)
$fullname = $conn->real_escape_string($_POST['fullname'] ?? '');
$id_number = $conn->real_escape_string($_POST['id'] ?? '');
$address = $conn->real_escape_string($_POST['address'] ?? '');
$sex = $conn->real_escape_string($_POST['sex'] ?? '');
$civil_status = $conn->real_escape_string($_POST['civil_status'] ?? '');
$phone = $conn->real_escape_string($_POST['phone'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$course = $conn->real_escape_string($_POST['course'] ?? '');
$year_level = $conn->real_escape_string($_POST['year_level'] ?? '');
$type_student = $conn->real_escape_string($_POST['type_student'] ?? '');
$school_name_last_attended = $conn->real_escape_string($_POST['school_name_last_attended'] ?? '');
$year_last_attended = $conn->real_escape_string($_POST['year_last_attended'] ?? '');
$scholarship = $conn->real_escape_string($_POST['scholarship'] ?? '');
$scholarship_name = $conn->real_escape_string($_POST['scholarship_name'] ?? '');
$mother_name = $conn->real_escape_string($_POST['mother_name'] ?? '');
$father_name = $conn->real_escape_string($_POST['father_name'] ?? '');
$mother_occupation = $conn->real_escape_string($_POST['mother_occupation'] ?? '');
$father_occupation = $conn->real_escape_string($_POST['father_occupation'] ?? '');
$mother_income = $conn->real_escape_string($_POST['mother_income'] ?? '');
$father_income = $conn->real_escape_string($_POST['father_income'] ?? '');
$student_signature = $conn->real_escape_string($_POST['student_signature'] ?? '');
$guardian_signature = $conn->real_escape_string($_POST['guardian_signature'] ?? '');
$guardian_name = $conn->real_escape_string($_POST['guardian_name'] ?? '');
$guardian_relationship = $conn->real_escape_string($_POST['guardian_relationship'] ?? '');
$date_of_application = $conn->real_escape_string($_POST['date_of_application'] ?? '');

// Insert query
$sql = "INSERT INTO students (
    fullname, id_number, address, sex, civil_status, phone, email, course, year_level, type_student,
    school_name_last_attended, year_last_attended, scholarship, scholarship_name,
    mother_name, father_name, mother_occupation, father_occupation, mother_income, father_income,
    student_signature, guardian_signature, guardian_name, guardian_relationship, student_picture, date_of_application
) VALUES (
    '$fullname', '$id_number', '$address', '$sex', '$civil_status', '$phone', '$email', '$course', '$year_level', '$type_student',
    '$school_name_last_attended', '$year_last_attended', '$scholarship', '$scholarship_name',
    '$mother_name', '$father_name', '$mother_occupation', '$father_occupation', '$mother_income', '$father_income',
    '$student_signature', '$guardian_signature', '$guardian_name', '$guardian_relationship', '$student_picture_path', '$date_of_application'
)";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Student data saved successfully."]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
>>>>>>> origin/main
?>