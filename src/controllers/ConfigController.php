<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class ConfigController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin(); 
        if($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index() {
        $user = UserHandler::getUser($this->loggedUser->id);
        $flash = '';

        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        $this->render('config', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'flash' => $flash
        ]);
    }

    public function editAction() {
        //Pega os dados do usuário logado no BD
        $user = UserHandler::getUser($this->loggedUser->id, false);
        //Recebe os dados do formulário
        $avatar = filter_input(INPUT_POST, 'avatar');
        $avatar = (!empty($avatar)) ? $avatar : $user->avatar;
        $cover = filter_input(INPUT_POST, 'cover');
        $cover = (!empty($cover)) ? $cover : $user->cover;
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email');
        $newEmail = filter_input(INPUT_POST, 'new-email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $password2 = filter_input(INPUT_POST, 'password2');
        $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($name && $newEmail && $birthdate) {
            if($password !== $password2) {
                $_SESSION['flash'] = 'Senhas digitadas são diferentes!';
                $this->redirect('/config');
            }

            $birthdate = explode('/', $birthdate);
            if(count($birthdate) != 3) {
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/config');
            }
            
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
            if(strtotime($birthdate) === false) {
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/config');
            }

            if(UserHandler::emailExists($newEmail) === false || $newEmail === $email) {
                $token = UserHandler::editUser($this->loggedUser->id, $avatar, $cover, $name, $city, $work, $newEmail, $password, $birthdate);
                $_SESSION['token'] = $token;
                $this->redirect('/config');
            } else {
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect('/config');
            }

        } else {
            $this->redirect('/config');
        }        
    }

}