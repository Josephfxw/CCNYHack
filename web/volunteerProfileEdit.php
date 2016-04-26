<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Welcome</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/custom.css" rel="stylesheet">

    <script src="js/jquery.js"></script>


</head>
    <body>
        <script src="js/navbarVolunteer.js"></script>

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
                        $width  = $manipulator->getWidth();
                        $height = $manipulator->getHeight();
                        $centreX = round($width / 2);
                        $centreY = round($height / 2);
                        // our dimensions will be 200x130
                        $x1 = $centreX - 100; // 200 / 2
                        $y1 = $centreY - 65; // 130 / 2

                        $x2 = $centreX + 100; // 200 / 2
                        $y2 = $centreY + 65; // 130 / 2

                        // center cropping to 200x130
                        $newImage = $manipulator->crop($x1, $y1, $x2, $y2);
                        // saving file to uploads folder
                        $manipulator->save('uploads/' . $_FILES['fileToUpload']['name']);
                        echo 'Done ...';
                    } else {
                        echo 'You must upload an image...';
                    }
                }



                echo '<img src="uploads/bird.png" alt="Smiley face" height="42" width="42">';
        ?>


    <hr class="">
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
             <h1 class=""><?php echo $_POST["username"]; ?></h1>


<br>
        </div>
      <div class="col-sm-2 img-padding"><a href="/users" class="pull-right"><img title="profile image" class="img-circle img-responsive" src="http://ichef.bbci.co.uk/news/976/media/images/83351000/jpg/_83351965_explorer273lincolnshirewoldssouthpicturebynicholassilkstone.jpg"></a>

        </div>
    </div>
  <br>

  <div class="panel panel-default">
    <div class="panel-heading">Public Profile</div>
    <div>
      <h5> Profile picture</h5>
      <?php echo '<img src="uploads/bird.jpeg" alt="Smiley face" height="42" width="42">'; ?>
      <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


          <input type="file" name="fileToUpload" id="fileToUpload" />


          <input type="submit" value="Upload" />

      </form>
      <p style="line-height: 20px"></p>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


          Name:<br>
          <input type="text" name="name" value = "Joe"><br>
          Public Email:<br>
          <input type="email" name="email" value = "Josephxwf@gmail.com"><br>
          Location:<br>
          <input type="text" name="location" value = "New York"><br>
          Avaliable Time:<br>
          <input type="text" name="avaliableTime" value = "Mon-Wed 4-6pm"><br>


          <input type="submit" value="Save" />

      </form>
    </div>




   </div>




         <script src="js/bootstrap.min.js"></script>
    </body>
</html>
