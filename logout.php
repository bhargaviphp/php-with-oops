<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['permissions']);
header("Location:index.php");
// end of logout file