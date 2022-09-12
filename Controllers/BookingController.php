<?php

namespace Controllers;

use Models\BookingModel;
use Models\RoomModel;  

class BookingController extends Controller
{
    public function bookingFormUser(): void
    {
        // instanciation d'un nouveau model
        // stockage de ce nouveau model dans une variable qui appel la methode "getRooms"
        // puis "render" de la vue avec sa variable pour l'affichage des categories      
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);
        $this -> render('booking', [
            'rooms' => $rooms
            ]);
    }
            

    public function create(): void
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
            $errorFirstName = 'first name empty';
            $error = true;
        }
        // n'autorise que les lettres
        if(!preg_match("/^[A-Za-z\-]+$/",($_POST['firstName'])))
        {
            $errorFirstName = 'first name my be written with letter only';
            $error = true;
        }

        if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
        {
            $errorLastName = 'last name empty';
            $error = true;         
        }

        if(!preg_match("/^[A-Za-z\-]+$/",($_POST['lastName'])))
        {
            $errorLastName = 'last name my be written with letter only';
            $error = true;
        }

        if(!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) 
        {
            $errorEmail= 'email invalid';
            $error = true;         
        }
        // si $_POST "birthDate" n'est pas défini ou est défini et vide ou que l'âge est inférieur à l'âge legal de 18 ans
        if(!isset($_POST["birthDate"]) || empty($_POST["birthDate"]) || intval($userAge) < intval($legalAge))
        {
            $errorBirthDate = 'birthdate incorrect';
            $error = true;
        }
        
        if(!isset($_POST['cat_id']) || (isset($_POST['cat_id']) && empty($_POST['cat_id']))) 
        {
            $errorCat_id= 'room not selected';
            $error = true;         
        }
        // si $_POST "check_in" n'est pas défini ou est défini et vide ou inférieur à la date du jour
        if(!isset($_POST['check_in']) || (isset($_POST['check_in']) && empty($_POST['check_in'])) || strtotime($_POST["check_in"]) < strtotime($dateDay))
        {
            $errorCheck_in= 'date of your arrival is incorrect';
            $error = true;            
        }
        // si $_POST "check_out" n'est pas défini ou est défini et vide ou que "check-in" est inférieur/egal à $_POST "check_out" ou que $_POST "check_out" est inférieur/égal à la date du jour
        if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out'])) || strtotime($_POST["check_out"]) <= strtotime($_POST["check_in"]) || strtotime($_POST['check_out']) <= strtotime($dateDay))
        {
            $errorCheck_out= 'date of your leaving is incorrect';
            $error = true;           
        }

        // stockage des messages d'erreur dans la variable $errors avec comme clé "message" qui est appelé dans la vue
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

            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);
            $this -> render('booking', [
                    'rooms' => $rooms,
                    'errors'=> $errors
                ]);
                
        }
        // sinon envoie de ces données correcte avec le $_POST dans la variable $data
        else
        {
            $model = new BookingModel;
            $data = [
               htmlspecialchars($_POST['lastName']),
               htmlspecialchars($_POST['firstName']),
               htmlspecialchars($_POST['birthDate']),
               htmlspecialchars($_POST['email'])
            ];

            $model -> newBooking($data);
            $cust_id = $model -> getLastCustomerId();
            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);
            $dataSuite = [
                $cust_id,
                htmlspecialchars($_POST['cat_id']),
                htmlspecialchars($_POST['check_in']),
                htmlspecialchars($_POST['check_out'])
    
            ];
            $model -> newBookingSuite($dataSuite);
            redirect('/home');
        }
    }
         
    public function search()
    {
        // recuperation des données envoyer par le js
        $content = file_get_contents("php://input");
        // decoder le fichier json pour recuperer l'id de la catégory permettant la recherche
        $data = json_decode($content, true);
        $search = $data['id'];
        // instanciation d'un nouveau model
        $modelRoom = new RoomModel();
        // appel de la methode du model "searchById" pour recupérer le titre de la category choisi
        $price = $modelRoom -> searchById($search);
        include'views/prix.phtml';
    }
                    
    public function edit(): void
    {
        /* faire afficher les données dans le formulaire pour l'UPDATE
        ** récupération de l'id pour la modification via $_GET dans une variable
        ** première variable $idCust pour récupérer le bon id dans la table "customers"
        ** deuxième variable $idBook pour récupérer le bon id dans la table "booking"
        */
        $idCust = $_GET['cust_id'];
        $idBook = $_GET['id_booking'];
        $editModel = new BookingModel();
        $form = $editModel -> findCustomer($idCust);
        $form2 = $editModel -> findBooking($idBook);
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);
        $this -> render('updateBooking', [
            'rooms' => $rooms,
            'form' => $form,
            'form2' =>$form2
        ]);
    }
    
        public function update() :void
        {
            /*
            * A la modification/validation du formulaire, afficher les erreurs de champs vide ou incorrect sous chaque input
            * chaque "if" doit vérifier la validité des champs
            * si le champs n'est pas défini ou n'est pas correct
            * afficher erreur message ="le champs n'est pas correct"
            */
            
            $getDay = getdate();
            $dateDay = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"];
            $legalBirthdate = $getDay["year"]-18 . "-" . $getDay["mon"] . "-" . $getDay["mday"];
            $legalAge = strtotime($dateDay) - strtotime($legalBirthdate);
            $userAge = strtotime($dateDay) - strtotime($_POST["birthDate"]);
            
            $error = false;
            $errorFirstName = '';
            $errorLastName='';
            $errorEmail='';
            $errorBirthDate='';
            $errorCat_id='';
            $errorCheck_in='';
            $errorCheck_out='';

            if(!isset($_POST['firstName']) || (isset($_POST['firstName']) && empty($_POST['firstName']))) 
            {
                $errorFirstName = 'first name incorrect';
                $error = true;
            }

            if(!preg_match("/^[A-Za-z\-]+$/",($_POST['firstName'])))
            {
            $errorFirstName = 'first name my be written with letter only';
            $error = true;
            }

            if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
            {
                $errorLastName = 'last name empty';
                $error = true;         
            }

            if(!preg_match("/^[A-Za-z\-]+$/",($_POST['lastName'])))
            {
            $errorLastName = 'last name my be written with letter only';
            $error = true;
            }

            if(!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) 
            {
                $errorEmail= 'email invalid';
                $error = true;         
            }

            if(!isset($_POST["birthDate"]) ||  empty($_POST["birthDate"]) || intval($userAge) < intval($legalAge))
            {
                $errorBirthDate = 'birthdate incorrect';
                $error = true;
            }

            if(!isset($_POST['cat_id']) || (isset($_POST['cat_id']) && empty($_POST['cat_id']))) 
            {
                $errorCat_id= 'room not selected';
                $error = true;         
            }

            if(!isset($_POST['check_in']) || (isset($_POST['check_in']) && empty($_POST['check_in'])) || strtotime($_POST["check_in"]) < strtotime($dateDay))
            {
                $errorCheck_in= 'date of your arrival is incorrect';
                $error = true;            
            }

            if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out'])) || strtotime($_POST["check_out"]) <= strtotime($_POST["check_in"]) || strtotime($_POST['check_out']) <= strtotime($dateDay))
            {
                $errorCheck_out= 'date of your leaving is incorrect';
                $error = true;           
            }

            $errors['message']=[
                'firstName'=> $errorFirstName,
                'lastName'  => $errorLastName,
                'email'  => $errorEmail,
                'birthDate'  => $errorBirthDate,
                'cat_id'  => $errorCat_id,
                'check_in'  => $errorCheck_in,
                'check_out'  => $errorCheck_out
            ];

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
                
                $modelRoom = new RoomModel();
                $rooms = $modelRoom -> getRooms(['cat_title']);
                $idCust = $_POST['cust_id'];
                $idBook = $_POST['id_booking'];
                $editModel = new BookingModel();
                // stockage du model dans 2 variables puis appel des methodes concernés
                $form = $editModel -> findCustomer($idCust);
                $form2 = $editModel -> findBooking($idBook);
                $this -> render('updateBooking', [
                        'rooms' => $rooms,
                        'form' => $form,
                        'form2' =>$form2,
                        'errors'=> $errors
                    ]);
            }
            else
            {
                // récupération des id dans les variables pour la modification
                $idCust = $_POST['cust_id'];
                $idBook = $_POST['id_booking'];
                $model = new BookingModel;
                $data = [
                htmlspecialchars($_POST['lastName']),
                htmlspecialchars($_POST['firstName']),
                htmlspecialchars($_POST['birthDate']),
                htmlspecialchars($_POST['email']),
                $idCust
                ];

                $model -> updateModelCustomers($data);
                $modelRoom = new RoomModel();
                $rooms = $modelRoom -> getRooms(['cat_title']);
                $dataSuite = [
                    htmlspecialchars($_POST['cat_id']),
                    htmlspecialchars($_POST['check_in']),
                    htmlspecialchars($_POST['check_out']),
                    $idBook
                ];

                $model -> updateModelBooking($dataSuite);
                redirect('/bookingList');
            }
    }

    public function delete() :void
    {
        // récupération de l'id dans une variable pour la suppression
        // appel de la méthode "deleteModel" dans le model pour supprimer les données lié à l'id selectionné
        // puis redirect vers la vue "bookingList"
        $id = $_GET['id'];
        $model = new BookingModel();
        $model -> deleteModel($id);
        redirect('/bookingList');
    }
}
    



        
