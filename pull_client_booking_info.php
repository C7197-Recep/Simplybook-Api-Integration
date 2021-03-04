<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    
</head>
<body>
    
    
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//IT IS HARD TO FIND THIS PIECE OF INFORMATION FROM API DOCS. 
//YOU NEED TO FIND AND UPLOAD THIS PHP FILE FROM simplybook.me TO MAKE THE API WORK
include 'JsonRpcClient.php';
$loginClient = new JsonRpcClient('https://user-api.simplybook.me' . '/login/');
$company_login="samplecompanyname";
$admin="sampleadmin";
$pass="samplepassword";
$token = $loginClient->getUserToken($company_login, $admin, $pass);
    
$client = new JsonRpcClient('https://user-api.simplybook.me' . '/admin/', array(
        'headers' => array(
            'X-Company-Login: ' . $company_login,
            'X-User-Token: ' . $token
        )
));

//HERE WE KNOW JUST E-MAIL OF OUR CLIENT, SO WE NEED TO GET HIS/HER SIMPLYBOOK ID FIRST
$client_info = $client->getClientList("sample-email@address.com");  
$client_id = $client_info[0]->id;

//KNOW, WE CAN PULL ALL BOOKINGS OF OUR CLIENT BY THE ID
$str=json_encode('{"client_id":'.$client_id.'}');
$arr = array ('client_id'=>$client_id);
$str = json_encode($arr);
$bookings = $client->getBookings($arr);

//I SHOW THE IMPORTANT PARTS OF THE INCOMING INFORMATION HERE
//YOU CAN INTEGRATE THIS INFORMATION TO YOUR WEBSITE AS YOU WISH
foreach ($bookings as $booking) {
  $event = $booking->event;
  $email = $booking->client_email;
  $name = $booking->client;
  $client_id = $booking->client_id;
  $id = $booking->id;
  echo "Booking ID: " . $id .  ", Client ID: " . $client_id . ", Name : " . $name . ", E-mail : " . $email . ", Event/Product : " . $event . "<br>";
}

?>
</body>
</html>
