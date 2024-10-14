<?php
include('../config.php');

$query = mysqli_query($notification,"UPDATE admin_notify SET notify_active = 0");