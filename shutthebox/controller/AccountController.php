<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\Interfaces\ResourceControllerInterface;

class AccountController extends BaseController
{
    public function menu(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('account.menu', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        var_dump($account);
        return View::make('account.menu', ['account' => $account, 'userlayout' => $user]);
    }

    public function movimentos(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('account.menu', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        return View::make('account.movimentos', ['account' => $account, 'userlayout' => $user]);
    }

    public function RechargeBalance(){

        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('account.saldo', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        return View::make('account.saldo', ['account' => $account, 'userlayout' => $user]);
    }

    public function insertRechargeBalance(){

        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('account.saldo', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        $acc = new Accounts(Post::getAll());
        $acc->user_id = $user->id;
        $acc->tipomovimento = "Carregamento";
        $acc->data = date("Y/m/d");
        if ($acc->is_valid()){
            if($acc->save()){

            }


        }

        return View::make('account.saldo', ['account' => $account, 'userlayout' => $user]);
    }


    public function transactions(){

        #$movimento = User::find_by_sql();

        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('account.transactions', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        return View::make('account.transactions', ['account' => $account, 'userlayout' => $user]);
    }



    public function check(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            if ((is_null($user))){
                return false;
            }elseif (strcmp($user->pwd, $pwd) != 0){
                return false;
            }elseif ($user->admin == 1){
                return true;
            }elseif ($user->banned == 1){
                return false;
            }else{
                return true;
            }
        }catch (Exception $exception){}
        return false;
    }

}