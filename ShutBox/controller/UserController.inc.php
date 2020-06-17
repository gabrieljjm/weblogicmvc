<?php

class UserController{

    function UserController(){

    }

    function create ($username, $password){

    }

    function login ($username, $password){
        //check db
        if ($this->authenticate($username, $password)){
            //start session for user...
            session_start();
            //instantiate for the UserModel.inc object
            $user = new inc($username);
            //set the user object to the session...
            $_SESSION['user'] = $user;
            //we tell the system that we authenticated the user
            return true;
        }
        else{
            return false;
        }
    }

    static function authenticate ($u, $p){
        $authentic =false;
        mysql_connect("localhost", "root","" );
        mysql_select_db("welogicmvc");

        $result = mysql_query("select * from users where nome = '$u' and pass ='$p'") or die ("Failed to query database" .mysql_error());
        $row = mysql_fetch_array($result);
        if($row['nome'] == $u && $row['pass'] == $p){
            echo "Login sucess";
        }
        return $authentic;
    }

    function logout(){
        //does logout procedures
        session_start();
        session_destroy();

    }
}