<?php

 function dd($arg)
{
 var_dump($arg);die();
}

function view($viewName , $params = []) {

    require_once  BASE_PATH .'\\App\\Layoutes\\header.php';

    if (file_exists($viewName) {
        require_once BASE_PATH . '\\App\\Views\\'.$viewName.'.php'
    });
    extract($params);
//    dd($params);

    require_once  BASE_PATH .'\\App\\Layoutes\\footer.php';
}

function query($sql, $params = [])
{
    global $pdh;
    $statement = $pdh->prepare($sql);
    if (!$statement) {
        show_error($pdh->errorInfo()[2]);
    }
    $statement->execute($params);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function route($route, array $params = [])
{
    $q = http_build_query($params);
    return "/?route=$route" . ($q ? "&$q" : '');
}