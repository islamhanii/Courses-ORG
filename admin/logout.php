<?php

    session_start();
    session_unset();
    session_destroy();
    require_once("../globals.php");
    Globals::redirectURL("admin/login.php");