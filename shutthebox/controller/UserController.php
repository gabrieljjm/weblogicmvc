<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\Interfaces\ResourceControllerInterface;

class UserController extends BaseController {

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
        if (!Post::has('email')){
            return View::make('user.create', ['userlayout' => null, 'msg' => ""]);
        }else{
            $user = new User(Post::getAll());
            if (!User::find('first',array('username' => $user->username))){
                if (!User::find('first',array('username' => $user->email))){
                    if ($user->is_valid()){
                        $user->save();
                        return Redirect::toRoute('user/login');
                    }else{
                        $msg = "Utilizador Inválido!";
                        return View::make('user.create', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
                    }
                }else{
                    $msg = "Email já foi usado!";
                    return View::make('user.create', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
                }
            } else {
                $msg = "Nome de utilizador já foi usado!";
                return View::make('user.create', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }
        }
    }

    public function login()
    {
        if ($this->check()){
            Redirect::toRoute('home/inicio');
        }else{
            try {
                Session::remove('username');
                Session::remove('pwd');
            }catch (Exception $exception){}
        }
        if (!Post::has('username')){
            return View::make('user.login', ['userlayout' => null, 'msg' => ""]);
        }else{
            $user = new User(Post::getAll());
            $usercompare = User::find_by_username($user->username);
            if ((is_null($usercompare))){
                $msg = "Utilizador não registado!";
                return View::make('user.login', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }elseif (strcmp($usercompare->pwd, $user->pwd) != 0){
                $msg = "Palavra-Passe errada!";
                return View::make('user.login', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }elseif ($usercompare->admin == 1){
                Session::set('username', $usercompare->username);
                Session::set('pwd', $usercompare->pwd);
                return Redirect::toRoute('home/inicio');
            }elseif ($usercompare->banned == 1){
                $msg = "Conta Banida!";
                return View::make('user.login', ['userlayout' => null, 'msg' => $msg]);
            }else{
                Session::set('username', $usercompare->username);
                Session::set('pwd', $usercompare->pwd);
                return Redirect::toRoute('home/inicio');
            }
        }
    }

    public function logout()
    {
        Session::remove('username');
        Session::remove('pwd');
        return Redirect::toRoute('user/login');
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

    public function profile(){
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return Redirect::toRoute('user/login');
        }
        $username = Session::get('username');
        $user = User::find_by_username($username);
        $scores = Score::all(array('conditions' => array('userid=?',$user->id), 'order' => 'matchdate desc'));
        return View::make('user.profile', ['userlayout' => $user, 'scores' => $scores]);
    }

    public function edit()
    {
        if (!$this->check()) {
            try {
                Session::remove('username');
                Session::remove('pwd');
            } catch (Exception $exception) {}
            return Redirect::toRoute('user/login');
        }
        if (!Post::has('email')){
            $username = Session::get('username');
            $user = User::find_by_username($username);
            return View::make('user.edit', ['userlayout' => $user, 'user' => $user, 'msg' => ""]);
        }else{
            $username = Session::get('username');
            $usercompare = User::find_by_username($username);
            $user = new User(Post::getAll());
            $emails = User::count(array('conditions' => array('email = ? AND username <> ?', $user->email, $username)));
            if ($emails == 0){
                $usercompare->update_attributes(Post::getAll());
                if($usercompare->is_valid()){
                    $usercompare->save();
                    Session::set('pwd', $usercompare->pwd);
                    return Redirect::toRoute('user/profile');
                } else {
                    // return form with data and errors
                    $msg = "Utilizador inválido!";
                    return View::make('user.edit', ['user' => $user, 'userlayout' => $usercompare, 'msg' => $msg]);
                }
            }else{
                $msg = "Email já foi registado noutra conta!";
                return View::make('user.edit', ['user' => $user, 'userlayout' => $usercompare, 'msg' => $msg]);
            }
        }
        /*
        $user = new User(Post::getAll());
        if (!strcmp($user->username,"")){
            View::make('user.login', ['userlayout' => null, 'msg' => ""]);
        }else{
            $usercompare = User::find_by_username($user->username);
            if ((is_null($usercompare))){
                $msg = "Utilizador não registado!";
                View::make('user.login', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }elseif (strcmp($usercompare->pwd, $user->pwd) != 0){
                $msg = "Palavra-Passe errada!";
                View::make('user.login', ['user' => $user, 'userlayout' => null, 'msg' => $msg]);
            }elseif ($usercompare->admin == 1){
                Session::set('username', $usercompare->username);
                Session::set('pwd', $usercompare->pwd);
                Redirect::toRoute('home/inicio');
            }elseif ($usercompare->banned == 1){
                $msg = "Conta Banida!";
                View::make('user.login', ['userlayout' => null, 'msg' => $msg]);
            }else{
                Session::set('username', $usercompare->username);
                Session::set('pwd', $usercompare->pwd);
                Redirect::toRoute('home/inicio');
            }
        }



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
        }*/
        /*
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
        }*/
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

    public function show($id)
    {
        // TODO: Implement show() method.
    }

    public function store()
    {
        // TODO: Implement store() method.
    }
}