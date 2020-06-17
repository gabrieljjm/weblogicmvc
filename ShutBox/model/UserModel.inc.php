<?php

class inc{
    private $username;

    function UserModel($username){
        $this ->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


}