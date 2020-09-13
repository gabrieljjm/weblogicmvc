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
            return Redirect::toRoute('user/login');
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $account = Accounts::find_by_user_id($user->id);

        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");

        if($montante[0]->soma <= 0 ){
            $mensagem = "O saldo atual não lhe permite jogar.";
            $removerBotao = "hidden";
            return View::make('game.menu', ['userlayout' => $user, 'account' => $account, 'montante' => $montante,  'mensagem'=>$mensagem,'saldo' => null, 'addBotao' => null, 'removeBt' => $removerBotao ]);

        }else{
            $saldoPositivo = "Ao premir o botão 'Ok' serão-lhe debitados 0,05 euros.";
            $adicionarBotao = "hidden";
            return View::make('game.menu', ['userlayout' => $user, 'account' => $account, 'montante' => $montante, 'saldo' => $saldoPositivo,  'mensagem' => null, 'addBotao' => $adicionarBotao, 'removeBt' => null  ]);
        }

        return View::make('game.menu', ['userlayout' => $user, 'account' => $account, 'montante' => $montante]);

    }


    public function game(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return Redirect::toRoute('user/login');
        }
        $name = Session::get('username');
        $user = User::find('first',array('username' => $name));
        $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");
        if($montante[0]->soma <= 0){
            return Redirect::toRoute('game/menu');
        }else{

            unset($_SESSION['game']);
            $name = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find('first',array('username' => $name));

            $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");
            if ($this->check($user, $pwd)){
                if (isset($_SESSION['game'])){
                    $game = $_SESSION['game']->CheckGame(Session::get('game'));
                    $_SESSION['game'] = $game;

                    return View::make('game.game', ['userlayout' => $user, 'game' => $game, 'montante' => $montante]);

                }else{
                    $game = Game::StartGame();
                    $_SESSION['game'] = $game;

                    $account = Accounts::find_by_user_id($user->id);
                    $acc = new Accounts(Post::getAll());
                    $acc->user_id = $user->id;
                    $acc->valor = - 0.05;
                    $acc->descricao ="Jogo";
                    $acc->tipomovimento = "Débito";
                    $acc->data = date("Y/m/d");
                    if ($acc->is_valid()){
                        $acc->save();
                    }


                    $montante = Accounts::find_by_sql("select sum(accounts.valor) as soma from accounts where accounts.user_id ='$user->id'");
                    return View::make('game.game', ['userlayout' => $user, 'game' => $game, 'account'=> $account, 'montante' => $montante]);

                }
            }
        }

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