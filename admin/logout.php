<?php

    session_start();
    session_unset();
    session_destroy();
    include_once("../globals.php");
    Globals::redirectURL("admin/login.php");