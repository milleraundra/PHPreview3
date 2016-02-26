<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // use Symfony\Component\HttpFoundation\Request;
    // Request::enableHttpMethodParameterOverride();

    /* Home page */
    $app->get('/', function() use ($app) {
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists'=>$stylists));
    });

    $app->post('/stylist/add', function() use ($app) {
        $app['debug']= true;
        $new_stylist = new Stylist($_POST['name'], $_POST['services'], $_POST['phone']);
        $new_stylist->save();
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists'=>$stylists));
    });

    $app->get('/stylist/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        
    })

    return $app;

 ?>
