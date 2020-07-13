<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\Interfaces\ResourceControllerInterface;

class UserController extends BaseController implements ResourceControllerInterface {

    public function create()
    {
        if ($this->check()){
            Redirect::toRoute('home/inicio');
        }else{
            try {
                Session::remove('email');
                Session::remove('pwd');
            }catch (Exception $exception){}
        }

        // create new resource (activerecord/model) instance
        // your form name fields must match the ones of the table fields
        $user = new User(Post::getAll());

        if (!strcmp($user->username,"")){
            View::make('user.create', ['userlayout' => null, 'msg' => ""]);
        }elseif (!User::find('first',array('username' => $user->username))){
            if (!User::find('first',array('email' => $user->email))){
                if($user->is_valid()){
                    $user->save();
                    Redirect::toRoute('user/login');
                }else{
                    $msg = "Utilizador inválido!!";
                    View::make('user.create', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
                }
            }else{
                $msg = "Email já foi usado!";
                View::make('user.create', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }
        } else {
            $msg = "Nome de utilizador já foi usado!";
            View::make('user.create', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
        }
    }

    public function login()
    {
        if ($this->check()){
            Redirect::toRoute('home/inicio');
        }else{
            try {
                Session::remove('email');
                Session::remove('pwd');
            }catch (Exception $exception){}
        }
        $user = new User(Post::getAll());
        if (!strcmp($user->email,"")){
            View::make('user.login', ['userlayout' => null, 'msg' => ""]);
        }else{
            $usercompare = User::find_by_email($user->email);
            if ((is_null($usercompare))){
                $msg = "Email não registado!";
                View::make('user.login', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }elseif (strcmp($usercompare->pwd, $user->pwd) != 0){
                $msg = "Palavra-Passe errada!";
                View::make('user.login', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }elseif ($usercompare->admin == 1){
                Session::set('email', $usercompare->email);
                Session::set('pwd', $usercompare->pwd);
                Redirect::toRoute('home/inicio');
            }elseif ($usercompare->banned == 1){
                $msg = "Conta Banida!";
                View::make('user.login', ['userlayout' => null, 'msg' => $msg]);
            }else{
                Session::set('email', $usercompare->email);
                Session::set('pwd', $usercompare->pwd);
                Redirect::toRoute('home/inicio');
            }
        }
    }

    public function logout()
    {
        Session::remove('email');
        Session::remove('pwd');
        Redirect::toRoute('user/login');
    }

    public function check(){
        try {
            $email = Session::get('email');
            $pwd = Session::get('pwd');
            $user = User::find_by_email($email);
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

    public function profile(){
        if (!$this->check()) {
            try {
                Session::remove('email');
                Session::remove('pwd');
                Redirect::toRoute('user/login');
            } catch (Exception $exception) {}
        }
        $email = Session::get('email');
        $user = User::find_by_email($email);
        $scores = Score::all();
        View::make('user.profile', ['userlayout' => $user, 'scores' => $scores]);
    }

    public function destroy($id)
    {
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                $useredit = User::find($id);
                $useredit->delete();
                Redirect::flashToRoute('backoffice/lista', ['user' => null]);
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }

        Redirect::toRoute('backoffice/lista');
    }

    public function ban($id)
    {
        $user = User::find($id);
        if ($user->banned == 1){
            $user->banned = 0;
        }else{
            $user->banned = 1;
        }
        $user->save();
        Redirect::toRoute('backoffice/lista');
    }

    public function admin($id)
    {
        $user = User::find($id);
        if ($user->admin == 1){
            $user->admin = 0;
        }else{
            $user->admin = 1;
        }
        $user->save();
        Redirect::toRoute('backoffice/lista');
    }

    public function editar($id)
    {
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                $useredit = User::find($id);
                if (is_null($useredit)) {
                    Redirect::toRoute('backoffice/lista');
                } else {
                    View::make('backoffice/editar', ['user' => $user, 'useredit' => $useredit]);
                }
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }
    }

    public function lista(){
        try {
            $name = Session::get('name');
            $pwd = Session::get('pwd');
            $user = User::find_by_name($name);
            if ($this->check($user, $pwd)){
                $users = User::all();
                return View::make('backoffice.lista', ['user' => $user, 'users' => $users]);
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }
    }

    public function update($id)
    {
        try {
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
                    Redirect::toRoute('backoffice/lista');
                } else {
                    // return form with data and errors
                    Redirect::flashToRoute('backoffice/editar', ['user' => $user, 'useredit' => $useredit], $id);
                }
            }
        }catch (Exception $e){
            Redirect::flashToRoute('home/inicio', ['user' => null]);
        }
    }





    public function index()
    {
        // TODO: Implement index() method.
    }

    public function edit($id)
    {
        // TODO: Implement index() method.
    }


    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function store()
    {
        // TODO: Implement store() method.
    }
}