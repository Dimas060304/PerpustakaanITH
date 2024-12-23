<?php
session_start();
if(!isset($_SESSION['username'])) {
    header('location:Halaman_login.html');
}?>