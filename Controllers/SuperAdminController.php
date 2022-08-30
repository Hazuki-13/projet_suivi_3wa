<?php

namespace Controllers;

use Models\AdminModel;
use Models\BookingModel;
use Models\RoomModel;

class SuperAdminController extends Controller
{    
    // public function showRooms(): void
    // {
    //     // instanciation d'un nouveau model
    //     $table = new \Models\RoomModel();
    //     // stockage de ce nouveau model dans une variable qui appel la methode "getRooms"
    //     $roomslist = $table -> getRooms($_GET['rooms']);
    //     // puis render de la vue
    //     $this -> render('super-admin-control');
        
    // }

    public function displayBookingAdmin(): void
    {
            // instanciation d'un nouveau model
            $model = new AdminModel;
            // stockage de ce nouveau model dans une variable qui appel la methode "readBooking"
            $bookingList = $model -> readBookings();
            // puis render de la vue avec sa variable
            $this -> render('super-admin-control',[
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
        // si $_POST "userName" n'est pas défini ou est défini et vide
        if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorUserName = 'username input empty';
            $error = true;
        }
        // si $_POST "userStatus" n'est pas défini ou est défini et vide
        if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorUserStatus = 'user status not selected';
            $error = true;
        }
        // si $_POST "email" n'est pas défini ou est défini et vide
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorEmail= 'email invalid';
            $error = true;         
        }
        // si $_POST "password" n'est pas défini ou est défini et vide
        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password'])))
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorPassword = 'password incorrect';
            $error = true;         
        }
        // si $_POST "confirmPassword" n'est pas défini ou est défini et vide
        if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorConfirmPassword = 'password incorrect';
            $error = true;         
        }
        // stockage des messages d'erreur dans la variable $errors avec comme clé "message" qui est appelé dans la vue
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
            // puis render de la vue avec la vaiable $erreur pour renseigner les champs pré rempli
            $this -> render('addAdmin', [
                'errors' => $errors
            ]);
            
        }
        // sinon envoie de ces données correcte avec le $_POST dans la variable $data
        else
        {
            // mise en place de la fonction password_hash dans une variable pour hasher le mot de passe
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            // instanciation d'un nouveau model
            $model = new AdminModel;
            // contenu de la variable $data
            $data = [
                htmlspecialchars($_POST['userName']),
                htmlspecialchars($_POST['userStatus']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($password)
            ];
            // envoie de ces données avec le $_POST via la variable $data
            // appel de la méthode "newAdmin" dans le model pour insérer les données du nouveau "admin" dans la table "users"
            $model -> newAdmin($data);
            // puis redirection vers la vue "users"
            redirect('/users');
        }
    }

    public function displayUsers(): void
    {
        // instanciation d'un nouveau model
        $model = new AdminModel;
        // appel de la methode "users" via une variable
        $userList = $model -> users();
        // puis render de la vue avec sa viariable necessaire
        $this -> render('users', [
            'users' => $userList
        ]);
    }

    public function edit(): void
    {

        // faire afficher les données dans le formulaire pour l'UPDATE
        // récupération de l'id pour la modification via $_GET dans une variable
        $userId = $_GET['user_id'];
        // instanciation d'un nouveau model (Booking)
        $editModel = new AdminModel();
        // ce nouveau model est stocker dans une variable $user puis appelle la methode "userById" dans le model concerné
        $user = $editModel -> userById($userId);
        // puis render de la vue avec sa variable $user necessaire pour pré-remplir le formulaire
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
        // si $_POST "userName" n'est pas défini ou est défini et vide
        if(!isset($_POST['userName']) || (isset($_POST['userName']) && empty($_POST['userName']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorUserName = 'username input empty';
            $error = true;
        }
        // si $_POST "userStatus" n'est pas défini ou est défini et vide
        if(!isset($_POST['userStatus']) || (isset($_POST['userStatus']) && empty($_POST['userStatus']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorUserStatus = 'user status not selected';
            $error = true;
        }
        // si $_POST "email" n'est pas défini ou est défini et vide
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorEmail= 'email invalid';
            $error = true;         
        }
        // si $_POST "password" n'est pas défini ou est défini et vide
        if(!isset($_POST['password']) || (isset($_POST['password']) && empty($_POST['password'])))
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorPassword = 'password incorrect';
            $error = true;         
        }
        // si $_POST "confirmPassword" n'est pas défini ou est défini et vide
        if(!isset($_POST['confirmPassword']) || (isset($_POST['confirmPassword']) && empty($_POST['confirmPassword'])) || ($_POST['confirmPassword'] !== ($_POST['password']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorConfirmPassword = 'password incorrect';
            $error = true;         
        }
        // stockage des messages d'erreur dans la variable $errors avec comme clé "message" qui est appelé dans la vue
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
            // récupération des info de la méthode "edit" qui contient la variable pour l'id et l'appel de la methode dans le model concerné
            $userId = $_POST['user_id'];
            // instanciation d'un nouvau model
            $editModel = new AdminModel();
            // stockage de ce nouveau model dans une variable qui appel la methode "userById" présente dans le model concerné
            $user = $editModel -> userById($userId);
            // puis render de la vue avec les variables $user et $erreur pour renseigner les champs pré rempli du bon id
            $this -> render('updateAdmin', [
                'user' => $user,
                'errors'=> $errors
            ]);
            
        }
        // sinon envoie de ces données correcte avec le $_POST dans la variable $data
        else
        {
            // récupération de l'id dans la variable pour la modification
            $userId = $_POST['user_id'];
            // mise en place de la fonction password_hash dans une variable pour hasher le mot de passe
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            // instanciation d'un nouveau model
            $model = new AdminModel;
            // contenu de la variable $data
            $data = [
                htmlspecialchars($_POST['userName']),
                htmlspecialchars($_POST['userStatus']),
                htmlspecialchars($_POST['email']),
                htmlspecialchars($password),
                $userId
            ];
                // envoie de ces données avec le $_POST via la variable $data
            // appel de la méthode "updateModelAdmin" dans le model pour modifier les données de l'"admin" dans la table "users"
            $model -> updateModelAdmin($data);
            // puis  redirect vers la vue "users"
            redirect('/users');
        }
    }
        
    public function delete() :void
    {
        // récupération de l'id dans une variable pour la suppression
        $id = $_GET['id'];
        // instanciation d'un nouvau model
        $model = new AdminModel();
        // appel de la méthode "deleteModel" dans le model pour supprimer les données lié à l'id selectionné
        $model -> deleteModelAdmin($id);
        // puis redirect vers la vue "users"
        redirect('/users');
    }
        
}

    
    