<?php
session_start();
$_SESSION['post_data'] = "";
session_unset();
session_destroy();
?>