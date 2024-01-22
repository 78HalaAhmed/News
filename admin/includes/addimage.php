<?php
// Get reference to uploaded image
$image_file = $_FILES["image"]; //image is the form input file element name

// Exit if no file uploaded
if (!isset($image_file)) {
    die('No file uploaded.');
}

// Exit if image file is zero bytes
if (filesize($image_file["tmp_name"]) <= 0) {
    die('Uploaded file has no contents.');
}

// Exit if is not a valid image file
$image_type = exif_imagetype($image_file["tmp_name"]);
if (!$image_type) {
    die('Uploaded file is not an image.');
}

// Get file extension based on file type, to prepend a dot we pass true as the second parameter
$image_extension = image_type_to_extension($image_type, true);

// Create a unique image name
$image_name = bin2hex(random_bytes(16)) . $image_extension;  //بيعطي اسم عشوائى
// $image_name = str_replace(" ", "_", $title) . $image_extension; // دا لو عايزة مخلهوش يحطلي هو اي اسم عشوائي ولكن يظهر الاسم اللي انا كتبته ودا افضل لاغراض الSEARCH ENGINE

// Move the temp image file to the images directory
move_uploaded_file(
    // Temp image location
    $image_file["tmp_name"],

    // New image location
    _DIR_ . "/../../img/" . $image_name
);
?>