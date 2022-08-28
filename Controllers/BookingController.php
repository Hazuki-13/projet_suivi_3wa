<?php

namespace Controllers;

use Models\BookingModel;
use Models\RoomModel;  

class BookingController extends Controller
{
    public function bookingFormUser()
    {
        // instanciation d'un nouveau model
        $modelRoom = new RoomModel();
        // stockage de ce nouveau model dans une variable qui appel la methode "getRooms"
        $rooms = $modelRoom -> getRooms(['cat_title']);
        // puis "render" de la vue avec sa variable pour l'affichage des categories      
        $this -> render('booking', [
            'rooms' => $rooms
            ]);
    }
            

    public function create()
    {
        /*
            _A la validation du formulaire, afficher les erreurs de champs vide ou incorrect sous chaque input
            _chaque "if" doit vérifier la validité des champs
            _si le champs n'est pas défini ou n'est pas correct
            _afficher erreur message ="le champs n'est pas correct"
        */
        // récupération de la date du jour.
        $getDay = getdate();
        // Soustraire de 18 l'année partir de la date du jour.
        $dateDay = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"];
        // resultat de la date de naissance minimale par rapport à la date du jour.
        $legalBirthdate = $getDay["year"]-18 . "-" . $getDay["mon"] . "-" . $getDay["mday"];
        // Nombre de seconde que contient 18 ans jusqu'à de la date actuelle.
        $legalAge = strtotime($dateDay) - strtotime($legalBirthdate);
        // Age de l'utilisateur en seconde.
        $userAge = strtotime($dateDay) - strtotime($_POST["birthDate"]);

        $error = false;
        $errorFirstName = '';
        $errorLastName='';
        $errorEmail='';
        $errorBirthDate='';
        $errorCat_id='';
        $errorCheck_in='';
        $errorCheck_out='';
        // si $_POST "firstName" n'est pas défini ou est défini et vide
        if(!isset($_POST['firstName']) || (isset($_POST['firstName']) && empty($_POST['firstName']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorFirstName = 'first name incorrect';
            $error = true;
        }
        // si $_POST "lastName" n'est pas défini ou est défini et vide
        if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorLastName = 'last name incorrect';
            $error = true;         
        }
        // si $_POST "email" n'est pas défini ou est défini et vide
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorEmail= 'email invalid';
            $error = true;         
        }
        // si $_POST "birthDate" n'est pas défini ou est défini et vide ou que l'âge est inférieur à l'âge legal de 18 ans
        if(!isset($_POST["birthDate"]) ||  empty($_POST["birthDate"]) || intval($userAge) < intval($legalAge))
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorBirthDate = 'birthdate incorrect';
            $error = true;
        }
        // si $_POST "cat_id" n'est pas défini ou est défini et vide
        if(!isset($_POST['cat_id']) || (isset($_POST['cat_id']) && empty($_POST['cat_id']))) 
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorCat_id= 'room not selected';
            $error = true;         
        }
        // si $_POST "check_in" n'est pas défini ou est défini et vide ou inférieur à la date du jour
        if(!isset($_POST['check_in']) || (isset($_POST['check_in']) && empty($_POST['check_in'])) || strtotime($_POST["check_in"]) < strtotime($dateDay))
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorCheck_in= 'date of your arrival is incorrect';
            $error = true;            
        }
        // si $_POST "check_out" n'est pas défini ou est défini et vide ou que "check-in" est inférieur/egal à $_POST "check_out" ou que $_POST "check_out" est inférieur/égal à la date du jour
        if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out'])) || strtotime($_POST["check_out"]) <= strtotime($_POST["check_in"]) || strtotime($_POST['check_out']) <= strtotime($dateDay))
        {
            // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
            $errorCheck_out= 'date of your leaving is incorrect';
            $error = true;           
        }

        // stockage des messages d'erreur dans la variable $errors avec comme cle "message" qui est appelé dans la vue
        $errors['message']=[
            'firstName'=> $errorFirstName,
            'lastName'  => $errorLastName,
            'email'  => $errorEmail,
            'birthDate'  => $errorBirthDate,
            'cat_id'  => $errorCat_id,
            'check_in'  => $errorCheck_in,
            'check_out'  => $errorCheck_out
        ];
        // si $error est égal à true alors renvoie des info pré-rempli précédement dans les champs "input" pour corriger les erreurs
        if($error == true)
        {
           $errors['data'] = [
            'lastName'  => htmlspecialchars($_POST['lastName']),
            'firstName'=> htmlspecialchars($_POST['firstName']),
            'email'  => htmlspecialchars($_POST['email']),
            'birthDate'  => htmlspecialchars($_POST['birthDate']),
            'cat_id'  => htmlspecialchars($_POST['cat_id']),
            'check_in'  => htmlspecialchars($_POST['check_in']),
            'check_out'  => htmlspecialchars($_POST['check_out'])
           ];
            // instanciation d'un nouvau model
            $modelRoom = new RoomModel();
            // stockage de ce nouveau model dans une variable qui appel la methode "getRooms" présente dans le model concerné
            $rooms = $modelRoom -> getRooms(['cat_title']);
            // puis "render" de la vue avec ses variables "rooms" et "errors" 
            $this -> render('booking', [
                    'rooms' => $rooms,
                    'errors'=> $errors
                ]);
                
        }
        // sinon envoie de ces données correcte avec le $_POST dans la variable $data
        else
        {
            // instanciation d'un nouveau model
            $model = new BookingModel;
            // contenu de la variable $data
            $data = [
               htmlspecialchars($_POST['lastName']),
               htmlspecialchars($_POST['firstName']),
               htmlspecialchars($_POST['birthDate']),
               htmlspecialchars($_POST['email'])
            ];
            // envoie de ces données avec le $_POST via variable $data
            // appel de la méthode "newBooking" dans le model pour insérer les données du nouveau "customer" dans la bonne table
            $model -> newBooking($data);
            // recuperer l'id de ce nouveau customer avec la méthode "getLastCustomerId" présente dans le model concerné
            $cust_id = $model -> getLastCustomerId();
            // instanciation d'un nouveau model
            $modelRoom = new RoomModel();
            // stockage de ce nouveau model dans une variable qui appel la methode "getRooms" présente dans le model concerné
            $rooms = $modelRoom -> getRooms(['cat_title']);
            // contenu de la variable $dataSuite
            $dataSuite = [
                $cust_id,
                htmlspecialchars($_POST['cat_id']),
                htmlspecialchars($_POST['check_in']),
                htmlspecialchars($_POST['check_out'])
    
            ];
            // envoie de ces données avec le $_POST via variable $dataSuite qui concerne une autre table
            // appel de la méthode "newBookingSuite" dans le model pour insérer les données du nouveau "booking" dans la bonne table
            $model -> newBookingSuite($dataSuite);
            // à la validation du formulaire redirection vers la page "home"
            redirect('/home');
        }
    }
         
    public function search()
    {
        // déclaration des variables pour la requête js
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);
        $search = $data['id'];
        // instanciation d'un nouveau model
        $modelRoom = new RoomModel();
        // stockage de ce nouveau model dans une variable qui appel la methode "getOneById" présente dans le fichier Database
        $price = $modelRoom -> getOneById('category', 'cat_id', $search);
        include'views/prix.phtml';
        

    }
            
    public function edit(): void
    {
        // faire afficher les données dans le formulaire pour l'UPDATE
        // récupération de l'id pour la modification via $_GET dans une variable
        // première variable $idCust pour récupérer le bon id dans la table "customers"
        $idCust = $_GET['cust_id'];
        // deuxième variable $idBook pour récupérer le bon id dans la table "booking"
        $idBook = $_GET['id_booking'];
        // instanciation d'un nouveau model (Booking)
        $editModel = new BookingModel();
        // ce nouveau model est stocker dans une variable $form puis appelle la methode "findCustomer" dans le model concerné
        $form = $editModel -> findCustomer($idCust);
        // puis ce nouveau model est stocker dans une autre variable $form2 pour appeler la methode "findBooking" dans le model concerné
        $form2 = $editModel -> findBooking($idBook);
        // instanciation d'un nouveau model (Room)
        $modelRoom = new RoomModel();
        // stockage du nouveau model (Room) dans une variable $rooms qui appelle la methode "getRooms" dans le model
        $rooms = $modelRoom -> getRooms(['cat_title']);
        // puis render de la vue "updateBooking" avec ses variables nécessaire à l'affichage des données
        $this -> render('updateBooking', [
            'rooms' => $rooms,
            'form' => $form,
            'form2' =>$form2
        ]);
    }
    

        
        public function update() :void
        {
            /*
            _A la modification/validation du formulaire, afficher les erreurs de champs vide ou incorrect sous chaque input
            _chaque "if" doit vérifier la validité des champs
            _si le champs n'est pas défini ou n'est pas correct
            _afficher erreur message ="le champs n'est pas correct"
            */
            
            // récupération de la date du jour.
            $getDay = getdate();
            // Soustraire de 18 l'année partir de la date du jour.
            $dateDay = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"];
            // resultat de la date de naissance minimale par rapport à la date du jour.
            $legalBirthdate = $getDay["year"]-18 . "-" . $getDay["mon"] . "-" . $getDay["mday"];
            // Nombre de seconde que contient 18 ans jusqu'à de la date actuelle.
            $legalAge = strtotime($dateDay) - strtotime($legalBirthdate);
            // Age de l'utilisateur en seconde.
            $userAge = strtotime($dateDay) - strtotime($_POST["birthDate"]);
            
            $error = false;
            $errorFirstName = '';
            $errorLastName='';
            $errorEmail='';
            $errorBirthDate='';
            $errorCat_id='';
            $errorCheck_in='';
            $errorCheck_out='';
            // si $_POST "firstName" n'est pas défini ou est défini et vide
            if(!isset($_POST['firstName']) || (isset($_POST['firstName']) && empty($_POST['firstName']))) 
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorFirstName = 'first name incorrect';
                $error = true;
            }
            // si $_POST "lastName" n'est pas défini ou est défini et vide
            if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorLastName = 'last name incorrect';
                $error = true;         
            }
            // si $_POST "email" n'est pas défini ou est défini et vide
            if(!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) 
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorEmail= 'email invalid';
                $error = true;         
            }
            // si $_POST "birthDate" n'est pas défini ou est défini et vide ou que l'âge est inférieur à l'âge legal de 18 ans
            if(!isset($_POST["birthDate"]) ||  empty($_POST["birthDate"]) || intval($userAge) < intval($legalAge))
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorBirthDate = 'birthdate incorrect';
                $error = true;
            }
            // si $_POST "cat_id" n'est pas défini ou est défini et vide
            if(!isset($_POST['cat_id']) || (isset($_POST['cat_id']) && empty($_POST['cat_id']))) 
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorCat_id= 'room not selected';
                $error = true;         
            }
            // si $_POST "check_in" n'est pas défini ou est défini et vide ou inférieur à la date du jour
            if(!isset($_POST['check_in']) || (isset($_POST['check_in']) && empty($_POST['check_in'])) || strtotime($_POST["check_in"]) < strtotime($dateDay))
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorCheck_in= 'date of your arrival is incorrect';
                $error = true;            
            }
            // si $_POST "check_out" n'est pas défini ou est défini et vide ou que "check-in" est inférieur/egal à $_POST "check_out" ou que $_POST "check_out" est inférieur/égal à la date du jour
            if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out'])) || strtotime($_POST["check_out"]) <= strtotime($_POST["check_in"]) || strtotime($_POST['check_out']) <= strtotime($dateDay))
            {
                // alors je stocke un message d'erreur dans une variable qui sera affiché dans la vue
                $errorCheck_out= 'date of your leaving is incorrect';
                $error = true;           
            }

            // stockage des messages d'erreur dans la variable $errors avec comme cle "message" qui est appelé dans la vue
            $errors['message']=[
                'firstName'=> $errorFirstName,
                'lastName'  => $errorLastName,
                'email'  => $errorEmail,
                'birthDate'  => $errorBirthDate,
                'cat_id'  => $errorCat_id,
                'check_in'  => $errorCheck_in,
                'check_out'  => $errorCheck_out
            ];
            // si $error est égal à true alors renvoie des info pré-rempli précédement dans les champs "input" pour corriger les erreurs
            if($error == true)
            {
            $errors['data'] = [
                'lastName'  => htmlspecialchars($_POST['lastName']),
                'firstName'=> htmlspecialchars($_POST['firstName']),
                'email'  => htmlspecialchars($_POST['email']),
                'birthDate'  => htmlspecialchars($_POST['birthDate']),
                'cat_id'  => htmlspecialchars($_POST['cat_id']),
                'check_in'  => htmlspecialchars($_POST['check_in']),
                'check_out'  => htmlspecialchars($_POST['check_out'])
                ];
                // instanciation d'un nouvau model
                $modelRoom = new RoomModel();
                // stockage de ce nouveau model dans une variable qui appel la methode "getRooms" présente dans le model concerné
                $rooms = $modelRoom -> getRooms(['cat_title']);
                // récupération des info de la méthode "edit" qui contient les 2 variables pour les id et l'appel des 2 methodes dans le model concerné
                $idCust = $_POST['cust_id'];
                $idBook = $_POST['id_booking'];
                $editModel = new BookingModel();
                $form = $editModel -> findCustomer($idCust);
                $form2 = $editModel -> findBooking($idBook);
                // puis render de la vue avec ses variable
                $this -> render('updateBooking', [
                        'rooms' => $rooms,
                        'form' => $form,
                        'form2' =>$form2,
                        'errors'=> $errors
                    ]);
            }
            // sinon envoie de ces données correcte avec le $_POST dans la variable $data
            else
            {
                // récupération des id dans les variables pour la modification
                $idCust = $_POST['cust_id'];
                $idBook = $_POST['id_booking'];
                // instanciation d'un nouvau model
                $model = new BookingModel;
                // contenu de la variable $data
                $data = [
                htmlspecialchars($_POST['lastName']),
                htmlspecialchars($_POST['firstName']),
                htmlspecialchars($_POST['birthDate']),
                htmlspecialchars($_POST['email']),
                $idCust
                ];
                // envoie de ces données avec le $_POST via variable $data
                // appel de la méthode "updateModelCustomers" dans le model pour mofifier les données du  "customer"
                $model -> updateModelCustomers($data);
                // instanciation d'un nouveau model
                $modelRoom = new RoomModel();
                // stockage de ce nouveau model dans une variable qui appel la methode "getRooms" présente dans le model concerné
                $rooms = $modelRoom -> getRooms(['cat_title']);
                // contenu de la variable $dataSuite;
                $dataSuite = [
                    htmlspecialchars($_POST['cat_id']),
                    htmlspecialchars($_POST['check_in']),
                    htmlspecialchars($_POST['check_out']),
                    $idBook
                ];
                // envoie de ces données avec le $_POST via variable $dataSuite qui concerne une autre table
                // appel de la méthode "updateModelBooking" dans le model pour modifier les données du "booking" dans la table en question
                $model -> updateModelBooking($dataSuite);
                // puis redirection vers la vue "bookingList"            
                redirect('/super-admin-control');
            }
    }

    public function delete() :void
    {
        $id = $_GET['id'];
        $model = new BookingModel();
        $model -> deleteModel($id);
        // puis redirect vers la vue "bookingList"
        redirect('/super-admin-control');
    }
    
}



        
