<?php

namespace Controllers;

use Models\BookingModel;
use Models\RoomModel; 
use Models\AdminModel;  

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

        $error = false;
        $errorFirstName = '';
        $errorLastName='';
        $errorEmail='';
        $errorBirthDate='';
        $errorCat_id='';
        $errorCheck_in='';
        $errorCheck_out='';
        
        if(!isset($_POST['firstName']) || (isset($_POST['firstName']) && empty($_POST['firstName']))) {
            $errorFirstName = 'first name incorrect';
            $error = true;
        }
                        
        if(!isset($_POST['lastName']) || (isset($_POST['lastName']) && empty($_POST['lastName']))) 
        {
            $errorLastName = 'last name incorrect';
            $error = true;         
        }

        if(!isset($_POST['email']) || (isset($_POST['email']) && empty     ($_POST['email']))) 
        {
            $errorEmail= 'email incorrect';
            $error = true;         
        }            
            
            
        if(!isset($_POST['birthDate']) || (isset($_POST['birthDate']) && empty($_POST['birthDate']))) {
            $errorBirthDate = 'birthdate incorrect';
            $error = true;        
        }            

            
        if(!isset($_POST['cat_id']) || (isset($_POST['cat_id']) && empty($_POST['cat_id']))) 
        {
            $errorCat_id= 'room not selected';
            $error = true;         
        }

                                                
        if(!isset($_POST['check_in']) || (isset($_POST['check_in']) && empty($_POST['check_in']))) 
        {
            $errorCheck_in= 'choose a date of your arrival';
            $error = true;            
        }

                        
        if(!isset($_POST['check_out']) || (isset($_POST['check_out']) && empty($_POST['check_out']))) {
            $errorCheck_out= 'choose a date of your leaving';
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
            'firstName'=> $_POST['firstName'],
            'lastName'  => $_POST['lastName'],
            'email'  => $_POST['email'],
            'birthDate'  => $_POST['birthDate'],
            'cat_id'  => $_POST['cat_id'],
            'check_in'  => $_POST['check_in'],
            'check_out'  => $_POST['check_out']
           ];
            // echo('<pre>');
            // print_r($_SESSION['data']);
            // echo ('</pre>');
            // die();

            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);

                // echo('<pre>');
                // print_r($data);
                // echo ('</pre>');
                // echo('<pre>');
                // print_r($dataSuite);
                // echo ('</pre
            $this -> render('booking', [
                    'rooms' => $rooms
                    // 'error' => $error
                ]);
                // $template =  'booking' ;
                // require 'Views/layout.phtml';
                // exit();
            // redirect('/booking');
                // die;
        }
        else
        {
            $model = new BookingModel;
            $data = [
               $_POST['firstName'],
               $_POST['lastName'],
               $_POST['birthDate'],
               $_POST['email']
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
                $_POST['cat_id'],
                $_POST['check_in'],
                $_POST['check_out']
    
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

    public function edit()
    {
        //pour faire afficher le formulaire pour l'UPDATE
        //id du
        $idCust = $_GET['cust_id'];
        $idBook = $_GET['id_booking'];
        // echo('<pre>');
        // print_r($_GET);
        // echo ('</pre>');
        // die();
        
        $model = new BookingModel();
        // $model2 = new BookingModel();
        $form = $model -> findCustomer($idCust);
        $form2 = $model -> findBooking($idBook);
        
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);
        // $model2 = new BookingModel();

        // $template =  'booking' ;
        // require 'MVC/Views/layout.phtml';
        // la methode render remplace le code précedent
        
        $this -> render('updateBooking', [
            'rooms' => $rooms
        ]);
        

    }

    public function update() :void
    {
        $idCust = $_POST['cust_id'];
        $model = new BookingModel();
        $data = [
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['birthDate'],
            $_POST['email']
        ];
        
        // echo('<pre>');
        // print_r($data);
        // echo ('</pre>');
        
        // $model -> newBooking($data);
        $model -> updateModelCustomers($data, $idCust);

        // on vient d'inserer des element new customer
        // recuperer l'id de ce nouveau customer
        // $cust_id = $model -> getLastCustomerId();
        
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);

        $idBook = $_POST['id_booking'];
        $model2 = new BookingModel();
        $dataSuite = [
            // $cust_id,
            $_POST['cat_id'],
            $_POST['check_in'],
            $_POST['check_out']
        ];
        
        // echo('<pre>');
        // print_r($dataSuite);
        // echo ('</pre>');
        // die();
        
        // $model -> updateModelCustomers($id, $data);
        // $model2 -> newBookingSuite($dataSuite);
        
        $model2 -> updateModelBooking($dataSuite, $idBook);

        redirect('/super-admin-control');
    }

    public function delete() :void
    {
        $id = $_GET['id'];
        // echo'<pre>';
        // var_dump($_GET);
        // echo '</pre>';
        // die();
        $model = new BookingModel();
        $model -> deleteModel($id);
        redirect('/super-admin-control');
    }
    
}



        
