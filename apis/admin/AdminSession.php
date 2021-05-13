<?php


class AdminSession
{
    public function __construct(){

    }
    public function isAdminLoggedIn(){
        if(!isset($_SESSION['username'])){
            return false;
        }
        if(!isset($_SESSION['is_admin'])){
            return false;
        }
        return $_SESSION['is_admin'];
    }
}