#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();

function requestProcessor($request)
{
	echo "received request".PHP_EOL;
	echo "DoLogin Function".PHP_EOL;
	registerUser();
  var_dump($request);
}

function registerUser($request)
{
    echo "register user called".PHP_EOL;
    $mydb = new mysqli('127.0.0.1','testuser','12345','testdb');


    if ($mydb->errno != 0)
    {
        echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        exit(0);
     }

     if(!isset($request['type']))
     {
        return "ERROR: unsupported message type";
        switch ($request['type'])
        {
            echo "in query as desired".PHP_EOL;
            case "validate"
                $username = $request['username'];
                $query = "SELECT * FROM users WHERE username = '$username'";
                $response = $mydb->query($query);

                if (mysqli_num_rows($response) > 0) //already present
                {
                    $password = $request['password'];
                    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password';";
                    if (mysqli_num_rows($response) > 0)
                    {
                        return array("returnCode" => '0', 'message'=>"Valid Login");
                        //valid user
                    }
                }

                return return array("returnCode" => '0', 'message'=>"Invalid Login");;
        }
     }
}

?>

