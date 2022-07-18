<?php

namespace Controllers;

use Models\BookingModel;
use Models\RoomModel;   

class BookingController extends Controller
{
    public function booking()
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
        $model = new BookingModel;
        $data = [
           $_POST['firstName'],
           $_POST['lastName'],
           $_POST['birthDate'],
           $_POST['email']
        ];
        $model -> newBooking($data);
        // on vient d'inserer des element new customer
        // recuperer l'id de ce nouveau customer
        $cust_id = $model -> getLastCustomerId();
        
        $modelRoom = new RoomModel();
        $rooms = $modelRoom -> getRooms(['cat_title']);
        
        $model2 = new BookingModel;
        $dataSuite = [
            $cust_id,
            $_POST['cat_id'],
            $_POST['check-in'],
            $_POST['check-out']

        ];
        
    $model2 -> newBookingSuite($dataSuite);
    
     
    redirect('/home');
}
    

        

    public function search()
    {
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);

        $search = $data['id'];
         
        $modelRoom = new RoomModel();
        $price = $modelRoom -> getOneById('category', 'cat_', $search);
        // file_put_contents('exemple.txt', $price['cat_price']);
        include'views/prix.phtml';

    }

    // public function errorForm ()
    // {
    //     try
    //     {
    //         if(isset($_POST['firstName']) && !empty($_POST['firstName'])) &&
    //         if(isset($_POST['lastName']) && !empty($_POST['lastName'])) &&
    //         if(isset($_POST['email']) && !empty($_POST['email'])) &&
    //         if(isset($_POST['birthDate']) && !empty($_POST['birthDate'])) &&
    //         if(isset($_POST['check-in']) && !empty($_POST['check-in'])) &&
    //         if(isset($_POST['check-out']) && !empty($_POST['check-out'])) &&
    //         if(isset($_POST['cat_id']) && !empty($_POST['cat_id']))
    //         {
                // $model = new BookingModel;
                // $data = [
        //    $_POST['firstName'],
        //    $_POST['lastName'],
        //    $_POST['birthDate'],
        //    $_POST['email'],
        //     $cust_id,
        //     $_POST['cat_id'],
        //     $_POST['check-in'],
        //     $_POST['check-out']

        // $model -> newBooking($data);
        // $model -> newBookingSuite([$dataSuite]);
        // redirect('/home');
        //     }
        //     else
        //     {
        //         throw new \Exception('Remplir tous les champs vide');
        //     }
        // }
        // catch(\Exception $error)
        // {
        //     $errorInput = $error -> showMessage();
        //     // redirect('BookingController&error= . $errorInput'); à Test
        //     // header('location: index.php?route=BookingController&error=' . $errorInput);
        //     exit();
        // }
    // }
}

// $model = new PostModel();
        
        // Tableau contenant les informations du formulaire
        // $formData = [
        //     'title' => $_POST['title'],
        //     'content' => $_POST['content'],
        //     'category_id' => $_POST['category']
        // ];
        
        // Insertion dans la base de données
        // $model->create($formData, 1);  // Id de l'utilisateur = 1 pour le moment (authentification pas encore mise en place)
        
        // Exemple sans passer par un tableau
        // $model->create($_POST['title'], $_POST['content'], $_POST['category'], 1);
        
        // Redirection vers la page d'accueil
        // redirect('/home');