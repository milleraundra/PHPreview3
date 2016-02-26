<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

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
        $matching_clients = $stylist->getClients();
        return $app['twig']->render('stylist.html.twig', array('stylist'=>$stylist, 'clients'=>$matching_clients));
    });

/* Individual Stylist pages */
    $app->get('/client/add/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('new_client.html.twig', array('stylist' => $stylist));
    });

/* Route to Edit or Delete Stylist */
    $app->get('/stylist/update/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit_delete.html.twig', array('stylist' => $stylist));
    });

    $app->post('/stylist/update/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->update($_POST['name'], $_POST['services'], $_POST['phone']);
        $matching_clients = $stylist->getClients();
        return $app['twig']->render('stylist.html.twig', array('stylist'=>$stylist, 'clients'=>$matching_clients));
    });

    $app->post('/stylist/delete/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists'=>$stylists));
    });

/* Add client to single stylist */
    $app->post('/client/add/{id}/submit', function($id) use ($app) {
        $new_client = new Client($_POST['name'], $_POST['number'], $id);
        $new_client->save();
        $stylist = Stylist::find($id);
        $matching_clients = $stylist->getClients();
        return $app['twig']->render('stylist.html.twig', array('stylist'=>$stylist, 'clients'=>$matching_clients));
    });

    return $app;


 ?>
