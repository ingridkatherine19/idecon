<?php
$to="elUx9zwxTUY:APA91bHlG8wjwywJMj87w4ZFHxr7dT8w9Tg9mS46-m9RFZ7EFmokhMU-D4E9-iLD6rYPXC6-ubyCVqtU3EKi4fDz2XocgBZb-EDCh_Dq9dtaJQeYXP7gVNe-9N7uGrp7vNEyPW0pegGN";
$title="This is my title";
$message="This is my message Push Notification";
sendPush($to,$title,$message);

function sendPush($to,$title,$message)
{
// API access key from Google API's Console
// replace API
define( 'API_ACCESS_KEY', 'AIzaSyDB_0qC5K6wJNzn6n5H9C0R_XVtUNFHURw');
$registrationIds = array($to);
$msg = array
(
'message' => $message,
'title' => $title,
'vibrate' => 1,
'sound' => 1

// you can also add images, additionalData
);
$fields = array
(
'registration_ids' => $registrationIds,
'data' => $msg
);
$headers = array
(
'Authorization: key=' . API_ACCESS_KEY,
'Content-Type: application/json'
);
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;
}
?>
