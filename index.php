<?php
include('assets/properties.php');
require('image-gallery-script.php');
include('image-upload-script.php');
include('image-delete-script.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <script type="text/javascript" src="assets/gallery-script.js"></script>
    <title>Gallery</title>
</head>

<body>
    <header>
        <div class="container p-5 my-5 bg-dark text-white">
            <h1>Image Gallery</h1>
        </div>
    </header>
    <main class="container mt-5">

        <!--======image gallery ========-->
        <div class="row">

            <?php
            if (!empty($fetchImage)) {
                $slideNumber = 1;
                foreach ($fetchImage as $img) {
            ?>

                    <div class="column">
                        <img src="uploads/<?php echo $img[Image::NAME]; ?>" onclick="openModal(); currentSlide(<?php echo $slideNumber; ?>)" class="hover-shadow cursor">
                    </div>
            <?php
                    $slideNumber++;
                }
            } else {
                echo '<p class="text-danger">There are no saved Images</p>';
                echo '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal" type="button">Add Image</button>';
            }
            ?>

        </div>
        <!--======image gallery ========-->


        <div id="galleryModal" class="modal">
            <span class="close cursor" onclick="closeModal()">&times;</span>

            <!--======image gallery modal========-->
            <div class="modal-content">

                <?php
                if (!empty($fetchImage)) {
                    $allSlidesAmount = count($fetchImage);
                    $slideNumber = 1;
                    foreach ($fetchImage as $img) {

                ?>
                        <div class="gallerySlides">
                            <div class="numbertext"><?php echo $slideNumber ?> / <?php echo $allSlidesAmount ?></div>

                            <img src="uploads/<?php echo $img[Image::NAME]; ?>" style="width:auto; max-width:100%; max-height:80vh;">

                            <button type="button" class="btn btn-danger deleteButton" id="deleteButton<?php echo $img[Image::ID]; ?>" name="delete">Delete</button>
                            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>

                            <div class="caption-container">
                                <p id="caption"><?php echo $img[Image::NAME] ?></p>
                            </div>
                            <div class="mt-2 metaData">
                                <ul>
                                    <li>Date taken: <?php echo $img[Image::DATE] ?></li>
                                    <li>Camera Brand: <?php echo $img[Image::MAKE] ?></li>
                                    <li>Camera Model: <?php echo $img[Image::MODEL] ?></li>
                                    <li>Lens: <?php echo $img[Image::LENS] ?></li>
                                    <li>Aperture: <?php echo $img[Image::APERTURE] ?></li>
                                    <li>Shutter Speed: <?php echo $img[Image::SHUTTER] ?></li>
                                    <li>ISO: <?php echo $img[Image::ISO] ?></li>
                                    <li>Focal Length: <?php echo $img[Image::FOCAL] ?></li>
                                    <li>35mm Focal Length: <?php echo $img[Image::FOCAL35MM] ?></li>
                                    <li>Metering Mode: <?php echo $img[Image::METERINGMODE] ?></li>
                                    <li>Flash Mode: <?php echo $img[Image::FLASH] ?></li>
                                </ul>
                            </div>
                            <script>
                                $('#deleteButton<?php echo $img[Image::ID]; ?>').on('click', function() {
                                    var ajaxurl = 'image-delete-script.php',
                                        data = {
                                            'delete': '<?php echo $img[Image::NAME]; ?>'
                                        };
                                    $.post(ajaxurl, data, function(response) {
                                        console.log("INFO | Images are uploaded successfully");
                                        location.reload();
                                    });
                                });
                            </script>
                        </div>
                <?php
                        $slideNumber++;
                    }
                } else {
                    echo '<p class="text-danger">There are no saved Images</p>';
                    echo '<button class="btn btn-primary addImageButton" data-bs-toggle="modal" data-bs-target="#addImageModal" type="button">Add Image</button>';
                }
                ?>
                <!--======image gallery model========-->


            </div>
        </div>
        <!--======image gallery end ========-->

    </main>

    <!--======add Image========-->
    <button class="btn btn-primary addImageButton" data-bs-toggle="modal" data-bs-target="#addImageModal" type="button">&plus;</button>

    <!-- The Modal -->
    <div class="modal" id="addImageModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Images</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="addForm">
                        <div class="input-group">
                            <input type="file" name="images[]" class="form-control" multiple>
                            <input type="submit" class="btn btn-success" value="Submit" name="submit">
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--======add Image end ========-->

    <script>
        window.post = function(url, data) {
            return fetch(url, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
        }
    </script>

</body>

</html>