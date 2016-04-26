<?php
// include ImageManipulator class
require_once('ImageManipulator.php');

if ($_FILES['fileToUpload']['error'] > 0) {
    echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
} else {
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
    // check if file Extension is on the list of allowed ones
    if (in_array($fileExtension, $validExtensions)) {
        $newNamePrefix = time() . '_';
        $manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
        // resizing to 200x200
        $newImage = $manipulator->resample(200, 200);
        // saving file to uploads folder
        $manipulator->save('uploads/' . $newNamePrefix . $_FILES['fileToUpload']['name']);
        echo 'Done ...';
    } else {
        echo 'You must upload an image...';
    }
}

echo "end";
