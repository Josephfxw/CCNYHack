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

//database
$dbopts = parse_url(getenv('DATABASE_URL'));
$app->register(new Herrera\Pdo\PdoServiceProvider(),
               array(
                   'pdo.dsn' => 'pgsql:dbname='.ltrim($dbopts["path"],'/').';host='.$dbopts["host"] . ';port=' . $dbopts["port"],
                   'pdo.username' => $dbopts["user"],
                   'pdo.password' => $dbopts["pass"]
               )
);

//qury database
$app->get('/db/', function() use($app) {
  $st = $app['pdo']->prepare('SELECT name FROM volunteerUsers_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row['name']);
    $names[] = $row;
  }

  return $app['twig']->render('database.twig', array(
    'names' => $names
  ));
});
// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->get('/signup.html', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('signup.html', array(
    'warning1' => "",'warning2' => "",'warning3' => "",'warning4' => "",
    'warning5' => "",'warning6' => "",'warning7' => "",'warning8' => ""
  ));
});
###################################################################################################
# checking if the new user exists
$app->post('/volunteerUserCheck', function() use($app) {
  $username=$_POST["username"]; # get username from the submit
  $email=$_POST["email"];
  $password1=$_POST["password1"];
  $password2=$_POST["password2"];

  $warning1 = "";
  $warning2 = "";
  $warning3 = "";
  $warning4 = "";
  $warning5 = "";
  $warning6 = "";
  $warning7 = "";
  $warning8 = "";

  $st = $app['pdo']->prepare('SELECT * FROM volunteerUsers_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row);
    $names[] = $row;
  }
  #return $app['twig']->render('show.html', array(
  #  'name' => $names
  #));

  if (count($names)>0){ # table exixts
    #foreach ($names as $name) { #loop through all the username in database

      foreach ($names as $value) {

     if ($value['name'] == $username)
        $warning1 = "User already exists.";

     if ($value['email'] == $email)
        $warning2 = "Email already exists.";

     }
     if ($username == "")
         $warning1 = "Username is empty.";

     if ($email == "")
         $warning2 = "Email is empty.";

     if ( $password1  =="")
         $warning3 ="Password is empty.";


     if ( $password1 !=   $password2)
       $warning4 = "Passwords don't match.";



    if ($warning1 != "" || $warning2 != "" ||$warning3 != "" || $warning4 != "")
        return $app['twig']->render('signup.html', array(
       'warning1' => $warning1, 'warning2' => $warning2,'warning3' => $warning3,'warning4' => $warning4,
       'warning5' => "",'warning6' => "",'warning7' => "",'warning8' => ""
     ));




    $st1 = $app['pdo']->prepare("INSERT into volunteerUsers_table ( name , email, password) values ('$username','$email','$password1')");
    $st1->execute();

    return $app['twig']->render('success.html', array(
      'name' => $username, 'password' => $password1
    ));

   }

   else { # table doesnot exixt, create table
     $st2 = $app['pdo']->prepare('CREATE table volunteerUsers_table ( name VARCHAR(60), email VARCHAR(60),password VARCHAR(60))');
     $st2->execute();

     if ($username == "")
         $warning1 = "Username is empty.";

     if ($email == "")
         $warning2 = "Email is empty.";

     if ( $password1  =="")
         $warning3 ="Password is empty.";

     if ( $password1 !=   $password2)
       $warning4 = "Passwords don't match.";

     if ($warning1 != "" || $warning2 != "" ||$warning3 != "" || $warning4 != "")
           return $app['twig']->render('signup.html', array(
          'warning1' => $warning1, 'warning2' => $warning2,'warning3' => $warning3,'warning4' => $warning4,
          'warning5' => "",'warning6' => "",'warning7' => "",'warning8' => ""
        ));


     $st3 = $app['pdo']->prepare("INSERT into volunteerUsers_table ( name , email, password) values ('$username','$email','$password1')");
     $st3->execute();
     return $app['twig']->render('success.html', array(
       'name' => $username, 'password' => $password1
     ));
   }


});

#####################################################################################################

# checking if the asststance user exists
$app->post('/UserForAssistanceCheck', function() use($app) {
  $username=$_POST["username2"];
  $email=$_POST["email2"];
  $password3=$_POST["password3"];
  $password4=$_POST["password4"];

  $warning1 = "";
  $warning2 = "";
  $warning3 = "";
  $warning4 = "";

  $warning5 = "";
  $warning6 = "";
  $warning7 = "";
  $warning8 = "";

  $st = $app['pdo']->prepare('SELECT * FROM UserForAssistance_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row);
    $names[] = $row;
  }
  #return $app['twig']->render('show.html', array(
  #  'name' => $names
  #));

  if (count($names)>0){ # table exixts
    #foreach ($names as $name) { #loop through all the username in database

      foreach ($names as $value) {

     if ($value['name'] == $username)
        $warning5 = "User already exists.";

     if ($value['email'] == $email)
        $warning6 = "Email already exists.";

     }
     if ($username == "")
         $warning5 = "Username is empty.";

     if ($email == "")
         $warning6 = "Email is empty.";

     if ( $password3  =="")
         $warning7 ="Password is empty.";


     if ( $password3 !=   $password4){

       $warning8 = "Passwords don't match.";
     }


    if ($warning5 != "" || $warning6 != "" || $warning7 !=""|| $warning8 != "")
        return $app['twig']->render('signup.html', array(
        'warning1' => "",'warning2' => "",'warning3' => "",'warning4' => "",
       'warning5' => $warning5, 'warning6' => $warning6,'warning7' => $warning7,'warning8' => $warning8
     ));




    $st1 = $app['pdo']->prepare("INSERT into UserForAssistance_table ( name , email, password) values ('$username','$email','$password3')");
    $st1->execute();

    return $app['twig']->render('success.html', array(
      'name' => $username, 'password' => $password1
    ));

   }

   else { # table not exixt
     $st2 = $app['pdo']->prepare('CREATE table UserForAssistance_table ( name VARCHAR(60), email VARCHAR(60),password VARCHAR(60))');
     $st2->execute();

     if ($username == "")
         $warning5 = "Username is empty.";

     if ($email == "")
         $warning6 = "Email is empty.";

     if ( $password3  =="")
         $warning7 ="Password is empty.";


     if ( $password3 !=   $password4)
       $warning8 = "Passwords don't match.";



     if ($warning5 != "" || $warning6 != "" || $warning7 !=""|| $warning8 != "")
         return $app['twig']->render('signup.html', array(
         'warning1' => "",'warning2' => "",'warning3' => "",'warning4' => "",
        'warning5' => $warning5, 'warning6' => $warning6,'warning7' => $warning7,'warning8' => $warning8
      ));

     $st3 = $app['pdo']->prepare("INSERT into UserForAssistance_table ( name , email, password) values ('$username','$email','$password3')");
     $st3->execute();

     return $app['twig']->render('success.html', array(
       'name' => $username, 'password' => $password1
     ));
   }


});



##################################################################################

$app->get('/postings.html', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('postings.html'

);
});

##################################################################################
$app->get('/about.html', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('about.html'

);
});

##################################################################################
$app->get('/home', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig'

);
});
##################################################################################
$app->post('/volunteerProfileEdit', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  $warning = "";
  $username = $_POST["username"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $location = $_POST["location"];
  $avaliableTime = $_POST["avaliableTime"];
  $bio = $_POST["bio"];

if ($_FILES['fileToUpload'] !== null){
  // include ImageManipulator class
  require_once('ImageManipulator.php');

  if ($_FILES['fileToUpload']['error'] > 0) {
      //echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
      $warning = "No pictures.";
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
          //echo 'Done ...';
      }
      else {
          //echo 'You must upload an image...';
          $warning = "No pictures.";
      }
  }
}


/*
$st = $app['pdo']->prepare('SELECT * FROM volunteerUsersInfo_table');
$st->execute();
$names = array();
while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
  $app['monolog']->addDebug('Row ' . $row);
  $names[] = $row;
}
#return $app['twig']->render('show.html', array(
#  'name' => $names
#));
*/
//if (count($names)>0){ # table exixts
  #foreach ($names as $name) { #loop through all the username in database
  $st = $app['pdo']->prepare("SELECT name , location, avaliableTime, bio FROM volunteerUsersInfo_table WHERE username = '$username'");
  $row = $st->fetch(PDO::FETCH_ASSOC);
  if (row["name"]!=$name || row ["location"] != $location || row["avaliableTime"]!=$avaliableTime || row["bio"] != $bio){
    $st1 = $app['pdo']->prepare(" UPDATE volunteerUsersInfo_table set name = '$name' , location ='$location' , avaliableTime ='$avaliableTime',bio = '$bio' WHERE username = '$username' ");
    $st1->execute();
     }

     return $app['twig']->render('volunteerProfileEdit.html', array(
     'username'=>$username,'name' => $name, 'location' =>$location, 'avaliableTime' =>$avaliableTime, 'warning' => $warning,'bio' =>$bio
   ));

 //}
/*
 else { # table not exixt, create volunteerUsersInfo_table
   $st2 = $app['pdo']->prepare('CREATE volunteerUsersInfo_table (username VARCHAR(60), name VARCHAR(60),location VARCHAR(60), avaliableTime VARCHAR(60) ');
   $st2->execute();

   $st3 = $app['pdo']->prepare("INSERT into volunteerUsersInfo_table  (username, name ,location, avaliableTime) values ('$username','$name','$location','$avaliableTime')");
   $st3->execute();


  return $app['twig']->render('volunteerProfileEdit.html', array(
  'username'=>$username,'name' => $name, 'location' =>$location, 'avaliableTime' =>$avaliableTime
));
}
*/

});

##################################################################################
$app->get('/login.html', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('login.html', array(
  'warning1' => "", 'warning2' => "",
  'warning3' => "", 'warning4' => ""
));
});
##################################################################################

$app->post('/volunteerLoginCheck', function() use($app) {
  $warning1 = "Incorrect Username.";
  $warning2 = "Incorrect Password.";


  $username=$_POST["username"];
  $password=$_POST["password"];
  $name = "Click 'Edit Profile'";
  $location = "Click 'Edit Profile'to add your bio here";
  $avaliableTime ="Click 'Edit Profile'";;
  $bio = "Click edit button to add your bio here";
  $joinDate = date("Y-m-d");


  $st = $app['pdo']->prepare('SELECT * FROM volunteerUsers_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row);
    $names[] = $row;
  }

  #if (count($names)>0){ # table exixts
    #foreach ($names as $name) { #loop through all the username in database


          foreach ($names as $value) {

         if ($value['name'] == $username)
             $warning1 = "UsernameCorrect";
         if ($value['password'] == $password )
             $warning2 = "PasswordCorrect";

          }

         if ($username == "")
             $warning1 = "Username is empty.";

         if ($password == "")
             $warning2 = "Password is empty.";

         if ($warning1 == "UsernameCorrect" && $warning2 == "PasswordCorrect" ){

           $st = $app['pdo']->prepare('SELECT * FROM volunteerUsersInfo_table');
           $st->execute();
           $names = array();
           while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
             $app['monolog']->addDebug('Row ' . $row);
             $names[] = $row;
           }
           #return $app['twig']->render('show.html', array(
           #  'name' => $names
           #));

           if (count($names)>0){ # table exixts
             #foreach ($names as $name) { #loop through all the username in database
             $st1 = $app['pdo']->prepare("SELECT name , location, avaliableTime,joinDate, bio FROM volunteerUsersInfo_table WHERE username = '$username'");
             $st1->execute();
             $row = $st1->fetch(PDO::FETCH_ASSOC);
             //if (row["name"]!=$name || row ["location"] != $location || row["avaliableTime"]!=$avaliableTime){
              // $st1 = $app['pdo']->prepare(" UPDATE volunteerUsersInfo_table set name = '$name' , location ='$location' , avaliableTime ='$avaliableTime' WHERE username = '$username' ");
              // $st1->execute();
              //  }
                $name = $row["name"];
                $location = $row["location"];
                $avaliableTime = $row["avaliableTime"];
                $joinDate = $row["joinDate"];
                $bio =$row['bio'];
                return $app['twig']->render('volunteerProfile.html', array(
                'username'=>$username,'name' => $name, 'location' =>$location, 'avaliableTime' =>$avaliableTime, 'joinDate' =>$joinDate,'bio' =>$bio
              ));

            }

            else { # table not exixt, create volunteerUsersInfo_table
              $st2 = $app['pdo']->prepare('CREATE volunteerUsersInfo_table (username VARCHAR(60), name VARCHAR(60),location VARCHAR(60), avaliableTime VARCHAR(60), joinDate VARCHAR(60),bio VARCHAR(120) ');
              $st2->execute();

              $st3 = $app['pdo']->prepare("INSERT into volunteerUsersInfo_table  (username, name ,location, avaliableTime, joinDate,bio) values ('$username','$name','$location','$avaliableTime','$joinDate','$bio')");
              $st3->execute();

             return $app['twig']->render('volunteerProfile.html', array(
             'username'=>$username,'name' => $name, 'location' =>$location, 'avaliableTime' =>$avaliableTime, 'joinDate' => $joinDate,'bio' =>$bio
           ));
}


}

         return $app['twig']->render('login.html', array(

                 'warning1' => $warning1, 'warning2' => $warning2,
                 'warning3' => "", 'warning4' =>""

                 #,'warning3' => "EnterUsername",'warning4' => "EnterPassword"

              ));

});

######################################################################################
$app->post('/helpSeekerLoginCheck', function() use($app) {

  $warning3 = "Incorrect Username.";
  $warning4 = "Incorrect Password.";

  $username=$_POST["username2"];
  $password=$_POST["password2"];
  $st = $app['pdo']->prepare('SELECT * FROM UserForAssistance_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row);
    $names[] = $row;
  }

  #if (count($names)>0){ # table exixts
    #foreach ($names as $name) { #loop through all the username in database

      foreach ($names as $value) {

     if ($value['name'] == $username)
         $warning3 = "UsernameCorrect";
     if ($value['password'] == $password )
         $warning4 = "PasswordCorrect";

      }

     if ($username == "")
         $warning3 = "Username is empty.";

     if ($password == "")
         $warning4 = "Password is empty.";

     if ($warning3 == "UsernameCorrect" && $warning4 == "PasswordCorrect" )
         return $app['twig']->render('user.html');


     return $app['twig']->render('login.html', array(
             'warning1' => "", 'warning2' =>"",
             'warning3' => $warning3, 'warning4' => $warning4

             #,'warning3' => "EnterUsername",'warning4' => "EnterPassword"

          ));



});
/////////////////////////////////////////////////////////////////////////////////////


$app->run();
