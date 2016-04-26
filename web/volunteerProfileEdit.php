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
        <script src="js/navbarVolunteerProfileEdit.js"></script>

        <?php
        require('../vendor/autoload.php');

        $app = new Silex\Application();
        $app['debug'] = true;

        // Register the monolog logging service
        $app->register(new Silex\Provider\MonologServiceProvider(), array(
          'monolog.logfile' => 'php://stderr',
        ));
        // Register view rendering
        $app->register(new Silex\Provider\TwigServiceProvider(), array(
            'twig.path' => __DIR__.'/views',
        ));

        $dbopts = parse_url(getenv('DATABASE_URL'));
        $app->register(new Herrera\Pdo\PdoServiceProvider(),
                       array(
                           'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
                           'pdo.username' => $dbopts["user"],
                           'pdo.password' => $dbopts["pass"]
                       )
        );



          return $app['twig']->render('database.twig', array(
            'names' => $names
          ));
    
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



            //    echo '<img src="uploads/bird.png" alt="Smiley face" height="42" width="42">';
        ?>


    <hr class="">
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
             <h1 class=""><?php echo $_POST["username"]; ?></h1>


<br>
        </div>

    </div>
  <br>

  <div class="panel panel-default" style= "width:50%"">
    <div class="panel-heading">Public Profile</div>
    <div>
      <h5> Profile picture</h5>
      <?php echo '<img src="uploads/bird.jpeg" alt="Smiley face" height="150" width="150">'; ?>
      <form enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

          <fieldset class="form-group">
          <input type="file" name="fileToUpload" id="fileToUpload" />
          </fieldset>

          <button type="submit" class="btn btn-primary">Upload</button>

      </form>
      <p style="line-height: 20px"></p>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">


        <fieldset class="form-group">
          <label for="name">Name</label> <br>
          <input type="text" class="form-control" name="name" value = "Joe"><br>
        </fieldset>

        <fieldset class="form-group">
          <label for="name">Email</label><br>
          <input type="email" class="form-control" name="email" value = "Josephxwf@gmail.com"><br>
        </fieldset>

        <fieldset class="form-group">
          <label for="name">Location</label><br>
          <input type="text" class="form-control" name="location" value = "New York"><br>
        </fieldset>

        <fieldset class="form-group">
          <label for="name">Avaliable Time</label><br>
          <input type="text" class="form-control" name="avaliableTime" value = "Mon-Wed 4-6pm"><br>
        </fieldset>

          <button type="submit" class="btn btn-primary">Save</button>

      </form>
    </div>




   </div>




         <script src="js/bootstrap.min.js"></script>
    </body>
</html>
