<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class GameController extends BaseController
{
//

    public function menu(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return View::make('game.menu', ['userlayout' => null]);
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);
        var_dump($account);
        return View::make('game.menu', ['userlayout' => $user, 'account' => $account]);
    }


    public function game(){
            unset($_SESSION['game']);
            $name = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find('first',array('username' => $name));
            if ($this->check($user, $pwd)){
                if (isset($_SESSION['game'])){
                    $game = $_SESSION['game']->CheckGame(Session::get('game'));
                    $_SESSION['game'] = $game;
                    return View::make('game.game', ['userlayout' => $user, 'game' => $game]);
                }else{
                    $game = Game::StartGame();
                    $_SESSION['game'] = $game;
                    return View::make('game.game', ['userlayout' => $user, 'game' => $game]);
                }
            }
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