<?php
include('../config.php');

$query = mysqli_query($notification,"SELECT COUNT(*) as total FROM admin_notify WHERE active = 1");
$notification_row = mysqli_fetch_assoc($query);
$response = [
    'data' => $notification_row['total']
];

echo json_encode($response);
