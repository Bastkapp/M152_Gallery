<?php

define('NOT_FOUND', 'Unavailable');
define('IMAGES_PATH', 'uploads/');
define('DEBUG', false);

class Database
{
    const HOST = 'localhost';
    const USER = 'root';
    const PASS = '';
    const NAME = 'image_gallery';
    const TABLE = 'image';
}

class Metadata
{
    const MAKE = 'make';
    const MODEL = 'model';
    const SHUTTER = 'shutter';
    const APERTURE = 'aperture';
    const DATE = 'date';
    const ISO = 'iso';
    const FOCAL = 'focal';
    const FOCAL35MM = '35mmfocal';
    const LENS = 'lens';
    const METERINGMODE = 'meteringmode';
    const FLASH = 'flash';
}

class Image
{
    const ID = 'id';
    const NAME = 'image_name';
    const MAKE = 'make';
    const MODEL = 'model';
    const SHUTTER = 'shutter_speed';
    const APERTURE = 'aperture';
    const DATE = 'date_taken';
    const ISO = 'iso';
    const FOCAL = 'focal_length';
    const FOCAL35MM = '35mm_equivalent_focal_length';
    const LENS = 'lens_make';
    const METERINGMODE = 'metering_mode';
    const FLASH = 'flash';
}

function info_to_console($message, $title = '')
{
    print_to_console('INFO', $message, $title);
}

function debug_to_console($message, $title = '')
{
    if (!DEBUG) return;
    print_to_console('DEBUG', $message, $title);
}

function print_to_console($type = 'LOG', $message, $title = '')
{
    if (is_array($message) || is_object($message))
        $output = json_encode($message, JSON_PRETTY_PRINT);
    else
        $output = $message;
    if ($title != '') $title = $title . ": ";

    if (str_contains($output, "'")) $output = str_replace("'", "\'", $output);
    if (str_contains($output, '"')) $output = str_replace('"', '\"', $output);
    if (str_contains($output, "\n")) $output = str_replace("\n", '\n', $output);
    if (str_contains($output, "\r")) $output = str_replace("\r", '\r', $output);
    if (str_contains($output, "\t")) $output = str_replace("\t", '\t', $output);
    if (str_contains($output, "\\\\")) $output = str_replace("\\\\", '\\', $output);

    echo '<script>console.log("' . $type . ' | ' . $title . $output . '");</script>';
}
