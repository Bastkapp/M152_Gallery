<?php

include('exifData.php');
include_once('assets/properties.php');

require_once('database.php');

$db = $conn;
$tableName = Database::TABLE;
// upload image on submit
if (isset($_POST['submit'])) {
    echo upload_image($tableName);
}

// upload image function
function upload_image($tableName)
{

    $uploadTo = "uploads/";
    $allowedImageType = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF');

    debug_to_console($_FILES, 'files');
    debug_to_console($_POST, 'post');

    $imageName = array_filter($_FILES['images']['name']);
    $imageTempName = $_FILES["images"]["tmp_name"];
    $tableName = trim($tableName);

    if (empty($imageName)) {
        $error = "Please Select Images..";
        return $error;
    }

    if (empty($tableName)) {
        $error = "You must declare table name";
        return $error;
    }

    foreach ($imageName as $index => $file) {
        $error = $savedImageData = '';

        $imageBasename = basename($imageName[$index]);
        $imagePath = $uploadTo . $imageBasename;
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
        if (in_array($imageType, $allowedImageType)) {
            // Upload image to server 
            if (move_uploaded_file($imageTempName[$index], $imagePath)) {

                $camera = cameraExif($imagePath);

                // Store image into database table
                $savedImageData .= "('" .
                    $imageBasename .
                    "','" . $camera['make'] .
                    "','" . $camera['model'] .
                    "','" . $camera['shutter'] .
                    "','" . $camera['aperture'] .
                    "','" . $camera['date'] .
                    "','" . $camera['iso'] .
                    "','" . $camera['focal'] .
                    "','" . $camera['35mmfocal'] .
                    "','" . $camera['lens'] .
                    "','" . $camera['meteringmode'] .
                    "','" . $camera['flash'] .
                    "')";
            } else {
                $error = 'File Not uploaded ! try again';
            }
        } else {
            $error .= $_FILES['file_name']['name'][$index] . ' - file extensions not allowed<br> ';
        }
        save_image($savedImageData, $tableName);
    }

    header('refresh:0');
    return $error;
}
// File upload configuration 
function save_image($savedImageData, $tableName)
{
    global $db;
    if (!empty($savedImageData)) {
        $saveImage = "INSERT INTO " . $tableName . " (" .
            "image_name, " .
            "make, " .
            "model, " .
            "shutter_speed, " .
            "aperture, " .
            "date_taken, " .
            "iso, " .
            "focal_length, " .
            "35mm_equivalent_focal_length, " .
            "lens_make, " .
            "metering_mode, " .
            "flash" .
            ") VALUES " . $savedImageData;

        debug_to_console('Saved Image Data: ' . $savedImageData);
        debug_to_console('Save Image SQL: ' . $saveImage);
        $exec = $db->query($saveImage);
        if ($exec) {
            info_to_console("Images are uploaded successfully");
        } else {
            echo  "Error: " .  $saveImage . "<br>" . $db->error;
        }
    }
}
