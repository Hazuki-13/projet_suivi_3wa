<?php

namespace Controllers;

use Models\AdminModel;

class AdminController extends Controller
{
    public function displayBookingAdmin(): void
    {
            $model = new AdminModel;
            $bookingList = $model -> readBookings();
            $this -> render('bookingList',[
                'booking' => $bookingList
            ]);
    }

    public function displayAddAdmin(): void
    {
        $this -> render('addAdmin');
    }       

    public function createNewAdmin(): void
    {
        // création de variables pour la gestion d'erreurs
        $error = false;
        $errorUserName = '';
        $errorUserStatus = '';
        $errorEmail ='';
        $errorPassword ='';
        $errorConfirmPassword ='';

        if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
        {
            $errorUserName = 'username input empty';
            $error = true;
        }

        if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
        {
            $errorUserStatus = 'user status not selected';
            $error = true;
        }

        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
        {
            $errorEmail= 'email invalid';
            $error = true;         
        }

        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password'])))
        {
            $errorPassword = 'password incorrect';
            $error = true;         
        }

        if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
        {
            $errorConfirmPassword = 'password incorrect';
            $error = true;         
        }

        $errors['message']=[
            'userName'=> $errorUserName,
            'userStatus'=> $errorUserStatus,
            'email'  => $errorEmail,
            'password'  => $errorPassword,
            'confirmPassword'  => $errorConfirmPassword
        ];
        // si $error est égal à true alors renvoie des info pré-rempli précédement dans les champs "input" pour corriger les erreurs
        if($error == true)
        {
            $errors["data"] = [
                'userName'=> htmlspecialchars($_POST['userName']),
                'userStatus'=> htmlspecialchars($_POST['userStatus']),
                'email'  => htmlspecialchars($_POST['email']),
                'password'  => htmlspecialchars($_POST['password']),
                'confirmPassword' => htmlspecialchars($_POST['confirmPassword'])
            ];

            $this -> render('addAdmin', [
                'errors' => $errors
            ]);
            
        }
        // sinon envoie de ces données correcte avec le $_POST dans la variable $data
        else
        {
            // mise en place de la fonction password_hash dans une variable pour hasher le mot de passe
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $model = new AdminModel;
            $data = [
                htmlspecialchars($_POST['userName']),
                htmlspecialchars($_POST['userStatus']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($password)
            ];

            $model -> newAdmin($data);
            // puis redirection vers la vue "users"
            redirect('/users');
        }
    }

    public function displayUsers(): void
    {
        $model = new AdminModel;
        $userList = $model -> users();
        $this -> render('users', [
            'users' => $userList
        ]);
    }

    public function edit(): void
    {

        // faire afficher les données dans le formulaire pour l'UPDATE
        // récupération de l'id pour la modification via $_GET dans une variable
        $userId = $_GET['user_id'];
        $editModel = new AdminModel();
        $user = $editModel -> userById($userId);
        $this -> render('updateAdmin', [
            'user' => $user
        ]);
    }

    public function update(): void
    {
        // création de variables pour la gestion d'erreurs
        $error = false;
        $errorUserName = '';
        $errorUserStatus = '';
        $errorEmail ='';
        $errorPassword ='';
        $errorConfirmPassword ='';

        if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
        {
            $errorUserName = 'username input empty';
            $error = true;
        }

        if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
        {
            $errorUserStatus = 'user status not selected';
            $error = true;
        }

        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
        {
            $errorEmail= 'email invalid';
            $error = true;         
        }

        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password'])))
        {
            $errorPassword = 'password incorrect';
            $error = true;         
        }

        if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
        {
            $errorConfirmPassword = 'password incorrect';
            $error = true;         
        }
        
        $errors['message']=[
            'userName'=> $errorUserName,
            'userStatus'=> $errorUserStatus,
            'email'  => $errorEmail,
            'password'  => $errorPassword,
            'confirmPassword'  => $errorConfirmPassword
        ];
        // si $error est égal à true alors renvoie des info pré-rempli précédement dans les champs "input" via $errors et sa clé "data" pour corriger les erreurs
        if($error == true)
        {
            $errors["data"] = [
                'userName'=> htmlspecialchars($_POST['userName']),
                'userStatus'=> htmlspecialchars($_POST['userStatus']),
                'email'  => htmlspecialchars($_POST['email']),
                'password'  => htmlspecialchars($_POST['password']),
                'confirmPassword' => htmlspecialchars($_POST['confirmPassword'])
            ];

            $userId = $_POST['user_id'];
            $editModel = new AdminModel();
            $user = $editModel -> userById($userId);
            $this -> render('updateAdmin', [
                'user' => $user,
                'errors'=> $errors
            ]);
            
        }
        // sinon envoie de ces données correcte avec le $_POST dans la variable $data
        else
        {
            $userId = $_POST['user_id'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $model = new AdminModel;
            $data = [
                htmlspecialchars($_POST['userName']),
                htmlspecialchars($_POST['userStatus']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($password),
                $userId
            ];

            $model -> updateModelAdmin($data);
            redirect('/users');
        }
    }
        
    public function delete() :void
    {
        // récupération de l'id dans une variable pour la suppression
        $id = $_GET['id'];
        $model = new AdminModel();
        $model -> deleteModelAdmin($id);
        redirect('/users');
    }
        
}

    
    