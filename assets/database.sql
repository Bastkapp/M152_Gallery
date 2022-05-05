CREATE DATABASE IF NOT EXISTS image_gallery;

USE image_gallery;

CREATE TABLE IF NOT EXISTS image(
    `id` INT NOT NULL AUTO_INCREMENT,
    `image_name` VARCHAR(255) NOT NULL,
    `make` VARCHAR(255) NOT NULL,
    `model` VARCHAR(255) NOT NULL,
    `shutter_speed` VARCHAR(255) NOT NULL,
    `aperture` VARCHAR(255) NOT NULL,
    `date_taken` VARCHAR(255) NOT NULL,
    `iso` VARCHAR(255) NOT NULL,
    `focal_length` VARCHAR(255) NOT NULL,
    `35mm_equivalent_focal_length` VARCHAR(255) NOT NULL,
    `lens_make` VARCHAR(255) NOT NULL,
    `metering_mode` VARCHAR(255) NOT NULL,
    `flash` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE = InnoDB;
