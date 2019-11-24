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
        'db',
        function () {
            
        // SQL Server Extension Sample Code:
            $connectionInfo = array("UID" => "jsteimle", "pwd" => '5Pb14%lVAzMU714$iOKi', "Database" => "cantine", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
            $serverName = "tcp:hackatum2019-jakob.database.windows.net,1433";
            $conn = sqlsrv_connect($serverName, $connectionInfo);
            return $conn;
        }
    );

    $container->set(
        'logger',
        function () {
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
        return $renderer->render($response, "home.php");
    });

    $app->get('/admin', function (Request $request, Response $response) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Admin Access");
        return $renderer->render($response, "admin/adminMain.php");
    });

    $app->get('/admin/check[/{table_id}]', function (Request $request, Response $response, $args) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Admin Access");
        
        $data = array();
        $data['transactions'] = array();
        if (isset($args['table_id']) || isset($_GET['table_id'])) {
            $db = $this->get('db');
            if (isset($_GET['table_id'])) {
                $table_id = $_GET['table_id'];
            } else {
                $table_id =$args['table_id'];
            }
            $getResults=sqlsrv_query($db, "SELECT * FROM meal m WHERE table_id=" . $table_id . " AND  year(timestamp) = year(CURRENT_TIMESTAMP) and month(timestamp) = month(CURRENT_TIMESTAMP) and day(timestamp) = day(CURRENT_TIMESTAMP) ORDER BY timestamp DESC;");
            
            if ($getResults == false) {
                echo(sqlsrv_errors());
            }
            $productCount = 0;
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $log->notice(1, $row);
                $data['transactions'][$productCount][0] = $row['meal_id'];
                $data['transactions'][$productCount][1] = $row['card_id'];
                $data['transactions'][$productCount][2] = $row['timestamp'];
                $data['transactions'][$productCount][3] = $row['table_id'];
                $data['transactions'][$productCount][4] = $row['total'];
                echo("<br/>");
                $productCount++;
            }
            sqlsrv_free_stmt($getResults);
            sqlsrv_close($db);
        }
        
        return $renderer->render($response, "admin/checkTable.php", $data);
    });

    $app->get('/admin/verifyTransactions[/{meal_id}]', function (Request $request, Response $response) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Admin Access");
        $data = array();
        $data['transactions'] = array();
        if (isset($args['meal_id']) || isset($_GET['meal_id'])) {
            $db = $this->get('db');
            if (isset($_GET['meal_id'])) {
                $meal_id = $_GET['meal_id'];
            } else {
                $meal_id = $args['meal_id'];
            }
            $getResults=sqlsrv_query($db, "SELECT m.meal_id, p.product_id, amount, price, pfand FROM meal m JOIN consists_of c ON (m.meal_id=c.meal_id) JOIN product p ON (c.product_id=p.product_id) WHERE m.meal_id=" . $meal_id . ";");
            
            if ($getResults == false) {
                echo(sqlsrv_errors());
            }
            $productCount = 0;
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $log->notice(2, $row);
                $data['transactions'][$productCount][0] = $row['meal_id'];
                $data['transactions'][$productCount][1] = $row['price'];
                $data['transactions'][$productCount][2] = $row['product_id'];
                $data['transactions'][$productCount][3] = $row['amount'];
                
                $productCount++;
            }
            sqlsrv_free_stmt($getResults);
            sqlsrv_close($db);
        }


        return $renderer->render($response, "admin/verifyTransaction.php", $data);
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
            $log->info("File Uploaded " . $filename);
            $command = 'python3 /var/www/hackatum2019/python/getImageData.py ' . $filename;
            $log->notice($command);
            system($command);
            sleep( 5 );
            $myfile = fopen("/var/www/hackatum2019/python/temp.txt", "r") or die("Unable to open file!");
            $string = fread($myfile,filesize("/var/www/hackatum2019/python/temp.txt"));
            fclose($myfile);
        }
        $log->notice($string);
        $objects = explode("|", $string);
        $log->notice($status);
        
        $data['recognized'] = json_decode($objects[0], true);
        $data['user'] = $objects[1];
        //$log->notice($data['user']);
        //$log->notice(1, $data['recognized']);
        //$log->notice("Entering Payment Gateway");
        return $renderer->render($response, "paymentGateway.php", $data);
    });


    $app->post('/payConfirm', function (Request $request, Response $response, $args) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Running payment confirmation");
        $postVar = $request->getParsedBody();
        foreach ($postVar as $key => $param) {
        }
        $log->notice("Data Received", $postVar);
        // $sampleData = array
        // (
        //     array("Fries", 1, 1.7),
        //     array("Coca Cola Classic 0.5L", 1, 1.3),
        //     array("Deposit", 1, 0.25),
        //     array("Currywurst", 1, 3.5)
        // );

        $data = array();
        $data['transactions'] = array();
        if (isset($args['table_id']) || isset($_GET['table_id'])) {
            $db = $this->get('db');
            if (isset($_GET['table_id'])) {
                $table_id = $_GET['table_id'];
            } else {
                $table_id =$args['table_id'];
            }
            $query = "
            BEGIN TRANSACTION
             DECLARE @DataID int;
             DECLARE @total money;
             DECLARE @card_id numeric(18,0) = 04200586721;
             DECLARE @table_id int = 2;
            
               INSERT INTO meal (card_id, table_id) VALUES (@card_id, @table_id);
               SELECT @DataID = @@IDENTITY;
               INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 1, 3);
               INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 3, 2);
               INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 2, 1);
               INSERT INTO consists_of (meal_id, product_id, amount) VALUES (@DataID, 4, 1);
               SELECT @total = (SELECT sum((coalesce(p.price+p.pfand, p.price, p.pfand)) * c.amount) 
                                FROM consists_of c, product p
                                WHERE c.meal_id=@DataID AND c.product_id=p.product_id);
               UPDATE meal SET total = @total WHERE meal_id = @DataID; 

               IF (select balance from student_card where card_id=@card_id)-@total>= 0
                   BEGIN
                   UPDATE student_card
                   SET balance = balance - @total
                   WHERE card_id=@card_id;
                   COMMIT
                   END
                ELSE
                    
                    ROLLBACK TRANSACTION;
            
            ";
            $getResults=sqlsrv_query($db, $query);
            
            sqlsrv_free_stmt($getResults);
            sqlsrv_close($db);
        }
        
        $data = array();
        $data['soldItems'] = array();
        $i=0;
        foreach ($postVar as $key => $quantity) {
            if ($key != "id") {
                $data['soldItems'][$i] = array($key, $quantity, 10);
            }
        }
        $data['studentName'] = $postVar['id'];
        $data['total'] = 0;
        foreach ($data['soldItems'] as $item) {
            $data['total'] += $item[1] * $item[2];
        }
        return $renderer->render($response, "paymentConfirmation.php", $data);
    });

    $app->get('/transactions[/{id}]', function (Request $request, Response $response, $args) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Running payment confirmation");
        $sampleData = array(
            array("03.11.2019", 8.3, "Mensa Garching"),
            array("04.11.2019", 7.3, "Studi-kaffee"),
            array("05.11.2019", 4.9, "Mensa Garching"),
            array("06.11.2019", 5.6, "Mensa Garching")
        );

        $data = array();
        $data['transactions'] = $sampleData;
        $data['studentName'] = "Robert Smith";
        $data['total'] = 0;
        foreach ($data['transactions'] as $item) {
            $data['total'] += $item[1];
        }
        return $renderer->render($response, "previousTransactions.php", $data);
    });

    $app->get('/paymentConfirmed', function (Request $request, Response $response, $args) {
        $renderer = $this->get('renderer');
        $log = $this->get('logger');
        $log->notice("Payment confirmed");

        $data = array();
        $data['studentName'] = "Robert Smith";
        $data['balance'] = 15;

        return $renderer->render($response, "paymentConfirmed.php", $data);
    });
};
