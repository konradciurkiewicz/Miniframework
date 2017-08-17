<?php
//function handleMissedException($e) {
//    echo "Przykro nam, ale coś się nie udało. Spróbuj ponownie później, a jeśli problem będzie się powtarzać, skontaktuj się z nami";
//    error_log('Nieobsłużony wyjątek: ' . $e->getMessage()
//        . ' in file ' . $e->getFile() . ' on line ' . $e->getLine());
//}
//set_exception_handler('handleMissedException');
require ('../vendor/autoload.php');


$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';

$dir = __DIR__.'/../src/app/controllers/';
if(file_exists($dir . $controller . '.php')){

    require $dir. $controller.'.php';
}
else{
    throw new Exception('Controller not found');
}
