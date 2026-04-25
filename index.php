<?php
require_once 'config/database.php';

if (isset($_SESSION['user_id'])) {
    redirect('modules/dashboard/');
} else {
    redirect('modules/login/');
}
?>