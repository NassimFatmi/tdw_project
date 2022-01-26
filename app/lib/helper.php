<?php

namespace TDW\LIB;

trait Helper
{
    public function redirect($path)
    {
        session_write_close();
        header('Location: ' . $path);
        exit;
    }

    public function isAuthenticated()
    {
        if (!isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] !== true) return false;
        else return true;
    }
    public function isAdmin()
    {
        if (!isset($_SESSION["admin"])) return false;
        else return true;
    }
}