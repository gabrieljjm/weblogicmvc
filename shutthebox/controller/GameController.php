<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class GameController extends BaseController
{
    public function menu(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                return View::make('game.menu', ['user' => $user]);
            }
        }catch (Exception $e){}
        Redirect::toURL('\weblogicmvc');
    }

    public function game(){
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                if (isset($_SESSION['game'])){
                    //$game = Game::CheckGame(Session::get('game'));
                    return View::make('game.game', ['user' => $user/*, 'game' => $game*/]);
                }else{
                    /*$game = Game::StartGame();
                    $_SESSION['game'] = $game;*/
                    return View::make('game.game', ['user' => $user/*, 'game' => $game*/]);
                }
            }
        Redirect::toURL('\weblogicmvc');
    }

    public function check($user, $pwd){
        if ((is_null($user))){
            return false;
        }elseif (strcmp($user->pwd, $pwd) !== 0){
            return false;
        }elseif ($user->admin == 1){
            return true;
        }elseif ($user->banned == 1){
            return false;
        }else{
            return true;
        }
    }
}