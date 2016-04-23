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
  $st = $app['pdo']->prepare('SELECT name FROM test_table');
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
    'warning1' => "Enter Usename",'warning2' => "Enter Email",'warning3' => "Enter password",'warning4' => "Re-enter password"
  ));
});

# checking if the new user exists
$app->post('/volunteerUserCheck.html', function() use($app) {
  $username=$_POST["username"];
  $email=$_POST["email"];
  $password1=$_POST["password1"];
  $password2=$_POST["password2"];

  $warning1 = "Enter Username";
  $warning2 = "Enter Email";
  $warning3 = "Enter Password";
  $warning4 = "Re-enter Password";

  $st = $app['pdo']->prepare('SELECT * FROM users_table');
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
        $warning1 = "User already exists!";

     if ($value['email'] == $email)
        $warning2 = "Email already exists!";

     }

     if ( $password1 !=   $password2){

       $warning4 = "Password doesn't match!";
     }


    if ($warning1 != "Enter Username" || $warning2 != "Enter Email" || $warning4 = "Re-enter Password")
        return $app['twig']->render('signup.html', array(
       'warning1' => $warning1, 'warning2' => $warning2,'warning3' => $warning3,'warning4' => $warning4
     ));




    $st1 = $app['pdo']->prepare("INSERT into users_table ( name , email, password) values ('$username','$email','$password1')");
    $st1->execute();

    return $app['twig']->render('success.html', array(
      'name' => $username, 'names' => $names
    ));

   }

   else { # table not exixt
     $st2 = $app['pdo']->prepare('CREATE table users_table ( name VARCHAR(60), email VARCHAR(60),password VARCHAR(60))');
     $st2->execute();


     if ( $password1 !=   $password2){

       $warning4 = "Password doesn't match!";
       return $app['twig']->render('signup.html', array(
      'warning1' => $warning1, 'warning2' => $warning2,'warning3' => $warning3,'warning4' => $warning4
    ));
     }
     $st3 = $app['pdo']->prepare("INSERT into users_table ( name , email, password) values ('$username','$email','$password1')");
     $st3->execute();
     return $app['twig']->render('success.html', array(
       'name' => $username, 'names' => $names
     ));
   }


});



# checking if the asststance user exists
$app->post('/volunteerUserCheck.html', function() use($app) {
  $username=$_POST["username2"];
  $email=$_POST["email2"];
  $password3=$_POST["password3"];
  $password4=$_POST["password4"];

  $warning5 = "Enter Username";
  $warning6 = "Enter Email";
  $warning7 = "Enter Password";
  $warning8 = "Re-enter Password";

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
        $warning5 = "User already exists!";

     if ($value['email'] == $email)
        $warning6 = "Email already exists!";

     }

     if ( $password3 !=   $password4){

       $warning8 = "Password doesn't match!";
     }


    if ($warning5 != "Enter Username" || $warning6 != "Enter Email" || $warning8 = "Re-enter Password")
        return $app['twig']->render('signup.html', array(
       'warning5' => $warning5, 'warning6' => $warning6,'warning7' => $warning7,'warning8' => $warning8
     ));




    $st1 = $app['pdo']->prepare("INSERT into UserForAssistance_table ( name , email, password) values ('$username','$email','$password3')");
    $st1->execute();

    return $app['twig']->render('success.html', array(
      'name' => $username, 'names' => $names
    ));

   }

   else { # table not exixt
     $st2 = $app['pdo']->prepare('CREATE table UserForAssistance_table ( name VARCHAR(60), email VARCHAR(60),password VARCHAR(60))');
     $st2->execute();


     if ( $password3 !=   $password4){

       $warning8 = "Password doesn't match!";
       return $app['twig']->render('signup.html', array(
      'warning5' => $warning6, 'warning6' => $warning6,'warning7' => $warning7,'warning8' => $warning8
    ));
     }

     $st3 = $app['pdo']->prepare("INSERT into UserForAssistance_table ( name , email, password) values ('$username','$email','$password3')");
     $st3->execute();

     return $app['twig']->render('success.html', array(
       'name' => $username, 'names' => $names
     ));
   }


});



$app->get('/login.html', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('login.html');
});

$app->get('/test.php', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('test.php');
});

$app->run();
