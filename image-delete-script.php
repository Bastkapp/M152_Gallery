<?php
include_once('assets/properties.php');
require_once('database.php');

$db = $conn;
$tableName = Database::TABLE;
$rootPath = IMAGES_PATH;

if (isset($_POST['delete'])) {
    debug_to_console('POST submitted', 'Delete');
    echo deleteImage($_POST['delete'], Database::TABLE, $rootPath);
}

function deleteImage($imageName, $tableName, $rootPath)
{
    delete_image($imageName, $tableName);

    $filename = $rootPath . $imageName;

    if (unlink($filename)) {
        info_to_console('The file ' . $filename . ' was deleted successfully!');
    } else {
        info_to_console('There was a error deleting the file ' . $filename);
    }
}

function delete_image($imageName, $tableName)
{
    global $db;
    $deleteImage = "DELETE FROM " . $tableName . " WHERE image_name='" . $imageName . "'";

    debug_to_console('Image Name: ' . $imageName, 'Delete');
    debug_to_console('Delete Image SQL: ' . $deleteImage, 'Delete');

    $exec = $db->query($deleteImage);
    if ($exec) {
        info_to_console("Record deleted successfully");
    } else {
        info_to_console("Error deleting record: " . $db->error);
    }
}
