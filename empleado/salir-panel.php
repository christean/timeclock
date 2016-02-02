<?php
ob_start();
session_start();
session_unset();
session_destroy();
Header("Location: ../index.php");
ob_end_flush();
?>