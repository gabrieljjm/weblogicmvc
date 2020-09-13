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
            return Redirect::toRoute('user/login');
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from `accounts` where accounts.user_id ='$user->id'");
        return View::make('account.menu', ['account' => $account, 'userlayout' => $user, 'montante' => $montante]);

    }

    public function movimentos(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return Redirect::toRoute('user/login');
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from `accounts` where accounts.user_id ='$user->id'");
        $mov = Accounts::find_by_sql("select accounts.data, accounts.valor, accounts.descricao, accounts.tipoMovimento from `accounts`
        where accounts.user_id ='$user->id'");
        return View::make('account.movimentos', ['account' => $account, 'userlayout' => $user, 'movimentos'=>$mov, 'montante' => $montante]);

    }

    public function insertRechargeBalance(){

        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return Redirect::toRoute('user/login');
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        $acc = new Accounts(Post::getAll());
        $acc->user_id = $user->id;
        $acc->tipomovimento = "Crédito";
        $acc->data = date("Y/m/d");

        if ($acc->is_valid()) {
            $acc->save();
            return Redirect::toRoute('account/saldo');
        }


        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from `accounts` where accounts.user_id ='$user->id'");
        return View::make('account.saldo', ['account' => $account, 'userlayout' => $user, 'montante' => $montante]);


    }



    public function check(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            $account = Accounts::find_by_user_id($user->id);
            if ((is_null($user)) && (is_null($account))){
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