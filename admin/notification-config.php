<?php
include('../config.php');

$query = mysqli_query($notification,"SELECT * FROM admin_notify WHERE active = 1");
$notify = [];

while($notifications = mysqli_fetch_assoc($query)){
    $notify[] = [
        'name' => $notifications['notify_name'],
        'email' => $notifications['notify_email'],
        'username' => $notifications['notify_username'],
        'img' => $notifications['notify_img'],
        'active' => $notifications['active']
    ];
}

// Include status in the JSON response
$response = [
    'status' => 'success',
    'data' => $notify
];

echo json_encode($response);
