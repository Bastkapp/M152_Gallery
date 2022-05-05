<?php
function cameraExif($imagePath)
{
  $exif_ifd0 = exif_read_data($imagePath, 'IFD0', 0);
  $exif_exif = exif_read_data($imagePath, 'EXIF', 0);

  debug_to_console($exif_ifd0, 'IFD0');
  debug_to_console($exif_exif, 'EXIF');

  // Make
  try {
    if (@array_key_exists('Make', $exif_ifd0)) {
      $camMake = $exif_ifd0['Make'];
    } else {
      $camMake = NOT_FOUND;
    }
  } catch (Exception $e) {
    $camMake = NOT_FOUND;
  }

  // Model
  if (@array_key_exists('Model', $exif_ifd0)) {
    $camModel = $exif_ifd0['Model'];
  } else {
    $camModel = NOT_FOUND;
  }

  // Shutter Speed
  if (@array_key_exists('ExposureTime', $exif_ifd0)) {
    $camExposure = $exif_ifd0['ExposureTime'] . ' s';
  } else {
    $camExposure = NOT_FOUND;
  }

  // Aperture
  if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
    $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
  } else {
    $camAperture = NOT_FOUND;
  }

  // Date Taken
  if (@array_key_exists('DateTimeOriginal', $exif_ifd0)) {
    $camDate = $exif_ifd0['DateTimeOriginal'];
  } else {
    $camDate = NOT_FOUND;
  }
  $date = date_create($camDate);

  // ISO
  if (@array_key_exists('ISOSpeedRatings', $exif_exif)) {
    $camIso = $exif_exif['ISOSpeedRatings'];
  } else {
    $camIso = NOT_FOUND;
  }

  // Focal Length
  if (@array_key_exists('FocalLength', $exif_exif)) {
    $camFocalLength = $exif_exif['FocalLength'];
  } else {
    $camFocalLength = NOT_FOUND;
  }
  $focal = eval('return ' . $camFocalLength . ';') . ' mm';

  // 35mm Focal Length
  if (@array_key_exists('FocalLengthIn35mmFilm', $exif_exif)) {
    $cam35mmFocalLength = $exif_exif['FocalLengthIn35mmFilm'] . ' mm';
  } else {
    $cam35mmFocalLength = NOT_FOUND;
  }

  // Lens
  if (@array_key_exists('UndefinedTag:0xA434', $exif_exif)) {
    $camLens = $exif_exif['UndefinedTag:0xA434'];
  } else {
    $camLens = NOT_FOUND;
  }

  // Metering Mode
  if (@array_key_exists('MeteringMode', $exif_exif)) {
    $camMeteringMode = $exif_exif['MeteringMode'];
  } else {
    $camMeteringMode = NOT_FOUND;
  }

  switch ($camMeteringMode) {
    case "0":
      $camMeteringModeName = 'Unknown';
      break;
    case "1":
      $camMeteringModeName = 'Average';
      break;
    case "2":
      $camMeteringModeName = 'Center Weighted Average';
      break;
    case "3":
      $camMeteringModeName = 'Spot';
      break;
    case "4":
      $camMeteringModeName = 'Multi Spot';
      break;
    case "5":
      $camMeteringModeName = 'Pattern';
      break;
    case "6":
      $camMeteringModeName = 'Partial';
      break;
    case "255":
      $camMeteringModeName = 'Other';
      break;
    default:
      $camMeteringModeName = 'Unavailable';
  }

  // Flash
  if (@array_key_exists('Flash', $exif_exif)) {
    $camFlash = dechex($exif_exif['Flash']);
  } else {
    $camFlash = NOT_FOUND;
  }

  switch ($camFlash) {
    case "0":
      $camFlashName = 'No Flash';
      break;
    case "1":
      $camFlashName = 'Flash';
      break;
    case "5":
      $camFlashName = 'Flash, No Strobe Return';
      break;
    case "7":
      $camFlashName = 'Flash, Strobe Return';
      break;
    case "9":
      $camFlashName = 'Flash, Compulsory';
      break;
    case "d":
      $camFlashName = 'Flash, Compulsory, No Strobe Return';
      break;
    case "f":
      $camFlashName = 'Flash, Compulsory, Strobe Return';
      break;
    case "10":
      $camFlashName = 'No Flash, Compulsory';
      break;
    case "18":
      $camFlashName = 'No Flash, Auto';
      break;
    case "19":
      $camFlashName = 'Flash, Auto';
      break;
    case "1d":
      $camFlashName = 'Flash, Auto, No Strobe Return';
      break;
    case "1f":
      $camFlashName = 'Flash, Auto, Strobe Return';
      break;
    case "20":
      $camFlashName = 'No Flash Function';
      break;
    case "41":
      $camFlashName = 'Flash, Red-eye';
      break;
    case "45":
      $camFlashName = 'Flash, Red-eye, No Strobe Return';
      break;
    case "47":
      $camFlashName = 'Flash, Red-eye, Strobe Return';
      break;
    case "49":
      $camFlashName = 'Flash, Compulsory, Red-eye';
      break;
    case "4d":
      $camFlashName = 'Flash, Compulsory, Red-eye, No Strobe Return';
      break;
    case "4f":
      $camFlashName = 'Flash, Compulsory, Red-eye, Strobe Return';
      break;
    case "59":
      $camFlashName = 'Flash, Auto, Red-eye';
      break;
    case "5d":
      $camFlashName = 'Flash, Auto, No Strobe Return, Red-eye';
      break;
    case "5f":
      $camFlashName = 'Flash, Auto, Strobe Return, Red-eye';
      break;
    default:
      $camFlashName = 'Unavailable';
  }


  $return = array();
  $return[Metadata::MAKE] = $camMake;
  $return[Metadata::MODEL] = $camModel;
  $return[Metadata::SHUTTER] = $camExposure;
  $return[Metadata::APERTURE] = $camAperture;
  $return[Metadata::DATE] = date_format($date, 'j F, Y');
  $return[Metadata::ISO] = $camIso;
  $return[Metadata::FOCAL] = $focal;
  $return[Metadata::FOCAL35MM] = $cam35mmFocalLength;
  $return[Metadata::LENS] = $camLens;
  $return[Metadata::METERINGMODE] = $camMeteringModeName;
  $return[Metadata::FLASH] = $camFlashName;
  return $return;
}
