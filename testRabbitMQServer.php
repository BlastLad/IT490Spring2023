#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
	echo "DoLogin Function".PHP_EOL;
	$mydb = new mysqli('127.0.0.1','testuser','12345','testdb');

if ($mydb->errno != 0)
{
        echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        exit(0);
}

echo "successfully connected to database".PHP_EOL;

$query = "select * from students;";

$response = $mydb->query($query);
if ($mydb->errno != 0)
{
        echo "failed to execute query:".PHP_EOL;
        echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
        exit(0);
}

    // lookup username in databas
    // check password
//    return true
    //return false if not valid
}
function seanFunc() {
	$mydb = new mysqli('127.0.0.1','testuser','12345','testdb');

	if ($mydb->errno != 0)
	{
        	echo "failed to connect to database: ". $mydb->error . PHP_EOL;
	        exit(0);
	}

	echo "successfully connected to database".PHP_EOL;

	$query = "select * from students;";

	$response = $mydb->query($query);
	if ($mydb->errno != 0)
	{
        	echo "failed to execute query:".PHP_EOL;
	        echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
        	exit(0);
	}
}

function requestProcessor($request)
{
	echo "received request".PHP_EOL;
	echo "DoLogin Function".PHP_EOL;
	seanFunc();
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
  case "query":
	  echo "in query as desired".PHP_EOL;  
	 $mydb = new mysqli('127.0.0.1','testuser','12345','testdb');
	if ($mydb->errno != 0)
        {
                echo "failed to connect to database: ". $mydb->error . PHP_EOL;
                exit(0);
        }
	$query = $request['query'];

        $response = $mydb->query($query);
    case "notlogin":
      return doLogin($request['username'],$request['password']);
    case "notvalidate_session":
      return doValidate($request['sessionId']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;
exit();
?>

