<?php

 function dd($arg)
{
    highlight_string("<?php\n\$data =\n" . var_export($arg, true) . ";\n?>");
    die();
}

function view($viewName , $params = []) {
    require_once  BASE_PATH .DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Layoutes'.DIRECTORY_SEPARATOR.'header.php';

    if (file_exists($viewName) {
        require_once BASE_PATH .DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.$viewName.('.php')
    });
    extract($params);

    require_once  BASE_PATH .DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Layoutes'.DIRECTORY_SEPARATOR.'footer.php';
}

function query($sql, $params = [])
{
    /** @var PDO $pdh */
    global $pdh;

    $statement = $pdh->prepare($sql);
    if (!$statement) {
       dd($pdh->errorInfo()[2]);
    }
    $statement->execute($params);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function route($route, array $params = [])
{
    $q = http_build_query($params);
    return "/$route" . ($q ? "?$q" : '');
}

function redirect($to)
{
    header("location: $to");
}