<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\Interfaces\ResourceControllerInterface;


class UserController extends BaseController implements ResourceControllerInterface {

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

    public function check($user, $pwd){
        if ((is_null($user))){
            return false;
        }elseif (strcmp($user->pwd, $pwd) !== 0){
            return false;
        }elseif ($user->admin == 1){
            return true;
        }else{
            return false;
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

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function store()
    {
        // TODO: Implement store() method.
    }

    public function show($id)
    {
        // TODO: Implement show() method.
    }
}