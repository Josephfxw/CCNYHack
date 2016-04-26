<?php
// include ImageManipulator class
include('ImageManipulator.php');
echo "0";

class Foo {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';


    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}

$foo = new Foo;
echo $foo->aMemberFunc();

$manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
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
        echo "1";
        echo $_FILES['fileToUpload']['tmp_name'];
        $manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
        // resizing to 200x200
        echo "2";
        $newImage = $manipulator->resample(200, 200);
        // saving file to uploads folder
        echo "3";
        $manipulator->save('uploads/' . $newNamePrefix . $_FILES['fileToUpload']['name']);
        echo 'Done ...';
    } else {
        echo 'You must upload an image...';
    }
}

echo "end";
