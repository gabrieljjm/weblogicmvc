<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;

class MainController extends BaseController
{
    public function indexhead(){

        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return Redirect::flashToRoute('home/menu', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");
        return Redirect::flashToRoute('home/menu', ['userlayout' => $user, 'soma' => $montante]);
    }

    public function index(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('home.menu', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");
        return View::make('home.menu', ['account' => $account, 'userlayout' => $user, 'montante' => $montante]);

    }




    public function top(){
        $top = User::find_by_sql('SELECT users.id, users.username,
                (SELECT COUNT(*) from `scores` where scores.userid = users.id and scores.playerA > scores.playerB) as \'win\',
                (SELECT COUNT(*) from `scores` where scores.userid = users.id and scores.playerA < scores.playerB) as \'def\',
                (SELECT COUNT(*) from `scores` where scores.userid = users.id and scores.playerA = scores.playerB) as \'tie\'
                FROM `users` ORDER BY (SELECT COUNT(*) from `scores` where scores.userid = users.id and scores.playerA > scores.playerB) DESC
                LIMIT 10');
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('home.top', ['userlayout' => null, 'top' => $top]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");
        return View::make('home.top', ['userlayout' => $user, 'top' => $top, 'account'=>$account, 'montante' => $montante]);
    }

    public function check(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            $account = Accounts::find_by_user_id($user->id);
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