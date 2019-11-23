<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;


function moveUploadedFile($directory, $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}


return function (App $app) {

    $container = $app->getContainer();

    $container->set(
        'logger', function() {
            $log = new Logger('debug');
            $firephp = new FirePHPHandler();
            $stream = new StreamHandler(__DIR__ .'/../logs/debug.log', Logger::DEBUG);
            $log->pushHandler($stream);
            $log->pushHandler($firephp);
            return $log;
        }
    );

    $container->set(
        'renderer',
        function () {
            return new PhpRenderer(__DIR__ .'/../app/templates');
        }
    );


    $app->get('/', function (Request $request, Response $response) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Main Page");
        return $renderer->render($response, "payment.php");
    });

    $app->get('/pay/{tid}', function (Request $request, Response $response, $args) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Payment on table with tableId:" . $args['tid']);
        $templateData = array(
            'tableID' => $args['tid']
        );
        return $renderer->render($response, "payment.php", $templateData);
    });
    
    $app->post('/paymentGateway', function (Request $request, Response $response) {
        

        $renderer = $this->get('renderer');
        $log = $this->get('logger');

        $postVar = $request->getParsedBody();
        foreach ($postVar as $key => $param) {
        }

        $directory = "../user_files/";
        
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['photo'];
        
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $log->warning("File Uploaded " . $filename);
        }
        
        $log->notice("Entering Payment Gateway");
        return $renderer->render($response, "paymentGateway.php");
    });


    $app->get('/payConfirm', function (Request $request, Response $response, $args) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Running payment confirmation");
        $sampleData = array
        (
        array("Fries", 1, 1.7),
        array("Coca Cola Classic 0.5L", 1, 1.3),
        array("Deposit", 1, 0.25),
        array("Currywurst", 1, 3.5)
        );

        $data = array();
        $data['soldItems'] = $sampleData;
        $data['studentName'] = "Robert Smith";
        $data['total'] = 0;
        foreach ($data['soldItems'] as $item) {
            $data['total'] += $item[1] * $item[2];
        }
        

        return $renderer->render($response, "paymentConfirmation.php", $data);
    });

};


