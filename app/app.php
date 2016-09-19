<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Inventory.php';


    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('items' => Inventory::getAll()));
    });

    $app->post("/", function() use ($app) {
        $inventory = new Inventory($_POST['item']);
        $inventory->save();
        return $app['twig']->render('index.html.twig', array('items' => Inventory::getAll()));
    });
    $app->post("/delete", function() use ($app) {
        Inventory::deleteAll();
        return $app['twig']->render('delete.html.twig');
    });
    $app->post("/search", function() use ($app) {
        $result = Inventory::find($_POST['input']);
        return $app['twig']->render('search.html.twig', array('result' =>$result));
    });


    // $app->get("/tasks", function() use ($app) {
    //     return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    // });
    //
    // $app->post("/delete_categories", function() use ($app) {
    //         Category::deleteAll();
    //         return $app['twig']->render('index.html.twig');
    // });
    //
    // $app->post("/delete_tasks", function() use ($app) {
    //     Task::deleteAll();
    //     return $app['twig']->render('index.html.twig');
    // });

    return $app;
?>
