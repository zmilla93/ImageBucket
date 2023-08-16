<?php
session_start();

// Default Session Values
if (!isset($_SESSION['logged'])) $_SESSION['logged'] = false;
if (!isset($_SESSION['username'])) $_SESSION['username'] = "N/A";
if (!isset($_SESSION['user-id'])) $_SESSION['user-id'] = -1;