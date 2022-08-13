<?php

namespace Controllers;

use Models\BookingModel;
use Models\RoomModel;  

class BookingController extends Controller
{
    public function bookingFormUser()
    {
        
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);

        // $template =  'booking' ;
        // require 'MVC/Views/layout.phtml';
        // la methode render remplace le code précedent
        
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
        //Je récupère la date du jours.
        $getDay = getdate();
        //Soustraire l'année de la date du jour par 18. Et conserver les jours et mois intact.
        $dateDay = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"];
        //Je trouve la date de naissance minimale par rapport au jour.
        $legalBirthdate = $getDay["year"]-18 . "-" . $getDay["mon"] . "-" . $getDay["mday"];

        $legalCheckOut = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"]+1;

        // Nombre de seconde qu'a vécu une personne pour avoir 18 ans à partir de la date actuelle.
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
        
        if(!isset($_POST['firstName']) || (isset($_POST['firstName']) && empty($_POST['firstName']))) 
        {
            $errorFirstName = 'first name incorrect';
            $error = true;
        }
                        
        if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
        {
            $errorLastName = 'last name incorrect';
            $error = true;         
        }
        
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) 
        {
            $errorEmail= 'email invalid';
            $error = true;         
        }


        // Si l'age de l'user en seconde et inférieur au nombre de seconde qu'a du vivre un individu pour avoir 18 ans à partir de la date du jour.
        if(!isset($_POST["birthDate"]) ||  empty($_POST["birthDate"]) || intval($userAge) < intval($legalAge))
        {
            $errorBirthDate = 'birthdate incorrect';
            $error = true;
        }
            
        // if(!isset($_POST['birthDate']) || (isset($_POST['birthDate']) && empty($_POST['birthDate'])) && isset($_POST['birthDate'] < strtotime($legalAge)) 
        // {
        //     $errorBirthDate = 'birthdate incorrect';
        //     $error = true;        
        // }

        if(!isset($_POST['cat_id']) || (isset($_POST['cat_id']) && empty($_POST['cat_id']))) 
        {
            $errorCat_id= 'room not selected';
            $error = true;         
        }

        //if(!isset($_POST["check_in"]) ||  empty($_POST["check_in"]) || strtotime($_POST["check_in"]) < strtotime($DateDay))

        if(!isset($_POST['check_in']) || (isset($_POST['check_in']) && empty($_POST['check_in'])) || strtotime($_POST["check_in"]) < strtotime($dateDay))
        {
            $errorCheck_in= 'date of your arrival is incorrect';
            $error = true;            
        }

        //if(!isset($_POST["check_out"]) ||  empty($_POST["check_out"]) || strtotime($_POST["check_in"]) > strtotime($_POST["check_out"]))

        if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out'])) || strtotime($_POST["check_in"]) >= strtotime($_POST["check_out"]) || strtotime($_POST['check_out']) <= strtotime($dateDay))
        {
            $errorCheck_out= 'date of your leaving is incorrect';
            $error = true;           
        }

        
        $_SESSION['message']=[
            'firstName'=> $errorFirstName,
            'lastName'  => $errorLastName,
            'email'  => $errorEmail,
            'birthDate'  => $errorBirthDate,
            'cat_id'  => $errorCat_id,
            'check_in'  => $errorCheck_in,
            'check_out'  => $errorCheck_out
        ];

        // echo('<pre>');
        // print_r($_SESSION['message']);
        // echo ('</pre>');
        // die();
        if($error)
        {
           $_SESSION["data"] = [
            'lastName'  => htmlspecialchars($_POST['lastName']),
            'firstName'=> htmlspecialchars($_POST['firstName']),
            'email'  => htmlspecialchars($_POST['email']),
            'birthDate'  => htmlspecialchars($_POST['birthDate']),
            'cat_id'  => htmlspecialchars($_POST['cat_id']),
            'check_in'  => htmlspecialchars($_POST['check_in']),
            'check_out'  => htmlspecialchars($_POST['check_out'])
           ];
            // echo('<pre>');
            // print_r($_SESSION['data']);
            // echo ('</pre>');
            // die();

            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);

            $this -> render('booking', [
                    'rooms' => $rooms
                ]);
                
        }
        else
        {
            $model = new BookingModel;
            $data = [
               htmlspecialchars($_POST['lastName']),
               htmlspecialchars($_POST['firstName']),
               htmlspecialchars($_POST['birthDate']),
               htmlspecialchars($_POST['email'])
            ];
    
                // echo('<pre>');
                // print_r($data);
                // echo ('</pre>');
    
            $model -> newBooking($data);
            // on vient d'inserer des element new customer
            // recuperer l'id de ce nouveau customer
            $cust_id = $model -> getLastCustomerId();
            
            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);
            
            // $model2 = new BookingModel;
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
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $search = $data['id'];
        
        $modelRoom = new RoomModel();
        $price = $modelRoom -> getOneById('category', 'cat_id', $search);
        // file_put_contents('exemple.txt', $price['cat_price']);
        include'views/prix.phtml';

    }

    public function edit(): void
    {
        //pour faire afficher le formulaire pour l'UPDATE
        //id du
        $idCust = $_GET['cust_id'];
        $idBook = $_GET['id_booking'];

        
        
        $editModel = new BookingModel();
        // $model2 = new BookingModel();
        $form = $editModel -> findCustomer($idCust);
        $form2 = $editModel -> findBooking($idBook);
        
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);
        // $model2 = new BookingModel();
        
        // echo('<pre>');
        // print_r($form);
        // echo ('</pre>');
        // echo('<pre>');
        // print_r($form2);
        // echo ('</pre>');
        // die();
        
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

         //Je récupère la date du jours.
        $getDay = getdate();
         //Soustraire l'année de la date du jour par 18. Et conserver les jours et mois intact.
        $dateDay = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"];
         //Je trouve la date de naissance minimale par rapport au jour.
        $legalBirthdate = $getDay["year"]-18 . "-" . $getDay["mon"] . "-" . $getDay["mday"];
        
        $legalCheckOut = $getDay["year"] . "-" . $getDay["mon"] . "-" . $getDay["mday"]+1;
         // Nombre de seconde qu'a vécu une personne pour avoir 18 ans à partir de la date actuelle.
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
        
        if(!isset($_POST['firstName']) || (isset($_POST['firstName']) && empty($_POST['firstName']))) 
        {
            $errorFirstName = 'first name incorrect';
            $error = true;
        }
                        
        if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
        {
            $errorLastName = 'last name incorrect';
            $error = true;         
        }
        //$email_a
        if(!isset($_POST['email']) || (isset($_POST['email']) && empty(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))) /*à verifier l'emplacement du filter email*/
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

                        
        if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out'])) || strtotime($_POST["check_in"]) >= strtotime($_POST["check_out"]) || strtotime($_POST['check_out']) < strtotime($legalCheckOut))
        {
            $errorCheck_out= 'date of your leaving is incorrect';
            $error = true;           
        }

        
        $_SESSION['message']=[
            'firstName'=> $errorFirstName,
            'lastName'  => $errorLastName,
            'email'  => $errorEmail,
            'birthDate'  => $errorBirthDate,
            'cat_id'  => $errorCat_id,
            'check_in'  => $errorCheck_in,
            'check_out'  => $errorCheck_out
        ];

        // echo('<pre>');
        // print_r($_SESSION['message']);
        // echo ('</pre>');
        // die();
        if($error)
        {
           $_SESSION["data"] = [
            'firstName'=> htmlspecialchars($_POST['firstName']),
            'lastName' => htmlspecialchars($_POST['lastName']),
            'email' => htmlspecialchars($_POST['email']),
            'birthDate' => htmlspecialchars($_POST['birthDate']),
            'cat_id' => htmlspecialchars($_POST['cat_id']),
            'check_in' => htmlspecialchars($_POST['check_in']),
            'check_out' => htmlspecialchars($_POST['check_out'])
           ];
            // echo('<pre>');
            // print_r($_SESSION['data']);
            // echo ('</pre>');
            // die();

            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);

            $idCust = $_POST['cust_id'];
            $idBook = $_POST['id_booking'];
            $editModel = new BookingModel();
            $form = $editModel -> findCustomer($idCust);
            $form2 = $editModel -> findBooking($idBook);

                // echo('<pre>');
                // print_r($form);
                // echo ('</pre>');
                // echo('<pre>');
                // print_r($form2);
                // echo ('</pre>');
                // die();

            $this -> render('updateBooking', [
                    'rooms' => $rooms,
                    'form' => $form,
                    'form2' =>$form2
                ]);
        }
        else
        {
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
    
                // echo('<pre>');
                // print_r($data);
                // echo ('</pre>');
    
            $model -> updateModelCustomers($data);
            
            
            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);
            
            // $model2 = new BookingModel;
            $dataSuite = [
                htmlspecialchars($_POST['cat_id']),
                htmlspecialchars($_POST['check_in']),
                htmlspecialchars($_POST['check_out']),
                $idBook
            ];
            
            $model -> updateModelBooking($dataSuite);
        
         
            redirect('/super-admin-control');
        }
    }

    public function delete() :void
    {
        $id = $_GET['id'];
        $model = new BookingModel();
        $model -> deleteModel($id);
        redirect('/super-admin-control');
    }
    
}



        
