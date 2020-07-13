<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class MainController extends BaseController
{
    public function indexhead(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            if ($this->check($user, $pwd)){
                Redirect::flashToRoute('home/inicio', ['userlayout' => $user]);
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['userlayout' => null]);
        }
    }

    public function index(){
        try {
            $username = Session::get('username');
            $pwd = Session::get('pwd');
            $user = User::find_by_username($username);
            if ($this->check($user, $pwd)){
                return View::make('home.inicio', ['userlayout' => $user]);
            }
        }catch (Exception $e){}
        try {
            //Session::remove('email');
            //Session::remove('pwd');
        }catch (Exception $e){}
        View::make('home.inicio', ['userlayout' => null]);
    }
/*
    public function update()
    {
        try {
            $id = $_POST['id'];
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                if ($id == $user->id){
                    Session::set('name', $name);
                    Session::set('pwd', $pwd);
                }
                $useredit = User::find($id);
                $useredit->update_attributes(Post::getAll());
                if($useredit->is_valid()){
                    $useredit->save();
                    Redirect::toRoute('home/perfil');
                }
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }
    }
*/

    public function check($user, $pwd){
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
    }
}