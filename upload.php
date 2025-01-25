<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $image = $_FILES['image'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedExtensions)) {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        exit;
    }
    $uploadDir = 'uploads/';
    $fileName = time() . "_" . basename($image['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($image['tmp_name'], $filePath)) {
        $stmt = $conn->prepare("INSERT INTO photos (title, image_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $filePath);
        $stmt->execute();
        $stmt->close();

        echo "File uploaded successfully!";
    } else {
        echo "Failed to upload the file.";
    }
}
header("Location: index.php");
exit;
