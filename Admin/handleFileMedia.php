<?php
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $uploadDirectory = '../Images/'; // Directory to save the images
    $fileName = uniqid() . '_' . basename($file['name']); // Generate a unique file name
    $uploadFile = $uploadDirectory . $fileName;

    // Check if the file is an image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($file['type'], $allowedTypes)) {
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            echo $uploadFile; // Return the full path of the uploaded image
        } else {
            http_response_code(500);
            echo "Error uploading file.";
        }
    } else {
        http_response_code(400);
        echo "Invalid file type. Only JPEG, PNG, and GIF images are allowed.";
    }
} else {
    http_response_code(400);
    echo "No file uploaded.";
}
?>