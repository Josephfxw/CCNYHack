<?php
// include ImageManipulator class

require_once('ImageManipulator.php');
echo "hello";

// fileToUpload is the name of our file input field
if ($_FILES['fileToUpload']['error'] > 0) {
    echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
} else {
    echo "File name: " . $_FILES['fileToUpload']['name'] . "<br />";
    echo "File type: " . $_FILES['fileToUpload']['type'] . "<br />";
    echo "File size: " . ($_FILES['fileToUpload']['size'] / 1024) . " Kb<br />";
    echo "Temp path: " . $_FILES['fileToUpload']['tmp_name'];
}
