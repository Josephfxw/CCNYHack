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
  return $app['twig']->render('signup.html');
});

# checking if the new user exists
$app->post('/newUserCheck.html', function() use($app) {
  $st = $app['pdo']->prepare('SELECT name FROM users_table');
  $st->execute();

  $names = array();
  while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
    $app['monolog']->addDebug('Row ' . $row['name']);
    $names[] = $row;
  }

if (count($names)>0){ # table exixts
  $st1 = $app['pdo']->prepare('INSERT into users_table values ($_POST["username"],$_POST["email"]),$_POST["password1"]');
  $st1->execute();
  return $app['twig']->render('success.html', array(
    'name' => $_POST["username"]
  ));

 }

 else { # table not exixt
   $st = $app['pdo']->prepare('CREATE TABLE users_table ( name VARCHAR, email VARCHAR,password VARCHAR)');

   $st1 = $app['pdo']->prepare('INSERT into users_table values ($_POST["username"],$_POST["email"]),$_POST["password1"]');
   $st->execute();
   $st1->execute();

   return $app['twig']->render('success.html', array(
     'name' => $_POST["username"]
   ));
 }


});



$app->get('/login.html', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('login.html');
});

$app->run();
