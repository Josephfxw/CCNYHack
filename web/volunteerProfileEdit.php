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
      <form enctype="multipart/form-data" method="post" action="upload2.php">

          
          <input type="file" name="fileToUpload" id="fileToUpload" />


          <input type="submit" value="Upload" />

      </form>
    </div>




   </div>




         <script src="js/bootstrap.min.js"></script>
    </body>
</html>
