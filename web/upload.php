<?php
if ($_FILES['fileToUpload']['error'] > 0) {
    echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
} else {
    echo "File name: " . $_FILES['fileToUpload']['name'] . "<br />";
    echo "File type: " . $_FILES['fileToUpload']['type'] . "<br />";
    echo "File size: " . ($_FILES['fileToUpload']['size'] / 1024) . " Kb<br />";
    echo "Temp path: " . $_FILES['fileToUpload']['tmp_name'];
    // array of valid extensions
    $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
    // get extension of the uploaded file
    $fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
    // check if file Extension is on the list of allowed ones

    if (in_array($fileExtension, $validExtensions)) {
        // we are renaming the file so we can upload files with the same name
        // we simply put current timestamp in fron of the file name
        $newName = time() . '_' . $_FILES['fileToUpload']['name'];
        echo "<br />".$newName;
        $destination = 'uploads/';

        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $destination)) {
            echo "succesfully copied";
        }
        else {
        echo "You must upload an image";
    }
  }
}

echo 'enddd';
