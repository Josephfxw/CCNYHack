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

  $st = $app['pdo']->prepare('SELECT * FROM users_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row);
    $names[] = $row;
  }

if (count($names)>0){ # table exixts
  #foreach ($names as $name) { #loop through all the username in database
  $warning1 = "Enter Username";
  $warning2 = "Enter Email";
  $warning3 = "Enter Password";
  $warning4 = "Re-enter Password";
    foreach ($names as $value) {

    if ($value['name'] == $username){
     $warning1 = "User alrready exists!"
    }
    if ($value['email'] == $email){
    $warning2 = "Email alrready exists!"
    }

}

return $app['twig']->render('signup.html', array(
  'warning1' =>"Enter Username",'warning2' => "Email Exists!",'warning3' => "Enter password",'warning4' => "Re-enter password",
));
  $st1 = $app['pdo']->prepare("INSERT into users_table ( name , email, password) values ('$username','$email','$password')");
  $st1->execute();




  return $app['twig']->render('success.html', array(
    'name' => $username, 'names' => $names
  ));

 }

 else { # table not exixt
   $st2 = $app['pdo']->prepare('CREATE table users_table ( name VARCHAR(30), email VARCHAR(20),password VARCHAR(20))');
   $st2->execute();
   $st3 = $app['pdo']->prepare("INSERT into users_table ( name , email, password) values ('$username','$email','$password')");
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



$app->run();
