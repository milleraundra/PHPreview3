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

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    $app->delete('/delete/all', function() use ($app) {
        Stylist::deleteAll();
        Client::deleteAll();
        $stylists = Stylist::getAll();
        return $app['twig']->render('index.html.twig', array('stylists'=>$stylists));
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

    $app->patch('/stylist/update/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->update($_POST['name'], $_POST['services'], $_POST['phone']);
        $matching_clients = $stylist->getClients();
        return $app['twig']->render('stylist.html.twig', array('stylist'=>$stylist, 'clients'=>$matching_clients));
    });

    $app->delete('/stylist/delete/{id}', function($id) use ($app) {
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

/* View Individual Client */
    $app->get('/client/{id}', function($id) use ($app) {
        $client = Client::find($id);
        $stylist= Stylist::find($client->getStylistId());
        return $app['twig']->render('client.html.twig', array('client'=>$client, 'stylist'=>$stylist));
    });

    $app->get('/client/update/{id}', function($id) use ($app) {
        $client = Client::find($id);
        return $app['twig']->render('client_edit_delete.html.twig', array('client'=>$client));
    });
/* Edit Individual Client Info */

    $app->patch('/client/update/{id}', function($id) use ($app) {
        $client = Client::find($id);
        $client->update($_POST['name'], $_POST['phone']);
        $stylist = Stylist::find($client->getStylistId());
        return $app['twig']->render('client.html.twig', array('client'=>$client, 'stylist'=>$stylist));
    });

    $app->delete('/client/delete/{id}', function($id) use ($app) {
        $client = Client::find($id);
        $stylist = Stylist::find($client->getStylistId());
        $client->delete();
        $matching_clients = $stylist->getClients();
        return $app['twig']->render('stylist.html.twig', array('stylist'=>$stylist, 'clients'=>$matching_clients));
    });

/* View All Stylists and Client */
    $app->get('/view/all', function() use ($app) {
        $clients = Client::getAll();
        $stylists = Stylist::getAll();
        return $app['twig']->render('all_stylists_clients.html.twig', array('stylists'=>$stylists, 'clients'=>$clients));
    });

    return $app;


 ?>
