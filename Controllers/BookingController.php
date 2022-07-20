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
        /*
            _A la validation du formulaire, afficher les erreurs de champs vide ou incorrect sous chaque input
            _chaque "if" doit vérifier la validité des champs
            _si le champs n'est pas défini ou n'est pas correct
            _afficher erreur message ="le champs n'est pas correct"
        */

        $data = [];
        // $cust_id = [];
        $dataSuite = [];
        $error = [];
        
        if(isset($_POST['firstName']) && !empty($_POST['firstName']))
        {
            // $data=[ $_POST['firstName']];
            array_push($data, $_POST['firstName']);
        }
        else{
            $error['firstName'] = ['firstName incorrect'];
            
        }
        if(isset($_POST['lastName']) && !empty($_POST['lastName']))
        {
            // $data=[ $_POST['lastName']];
            array_push($data, $_POST['lastName']);
        }
        else{
            $error['lastName'] = ['lastName incorrect'];
            
        }
        if(isset($_POST['email']) && !empty($_POST['email']))
        {
            $data=[ $_POST['email']];
        }
        else{
            $error['email'] = ['email incorrect'];
            
        }
        if(isset($_POST['birthDate']) && !empty($_POST['birthDate']))
        {
            $data=[ $_POST['birthDate']];
        }
        else{
            $error['birthDate'] = ['birthDate incorrect'];
            
        }
        // $cust_id = $model -> getLastCustomerId();
        // if(isset($cust_id['cust_id']) && !empty($cust_id['cust_id']))
        // {
        //     $cust_id = ['cust_id'];
        // }
        // else{
        //     $error[$cust_id] = ['unexpected error!'];
            
        // }
        if(isset($_POST['cat_id']) && !empty($_POST['cat_id']))
        {
            $dataSuite=[$_POST['cat_id']];
        }
        else{
            $error['cat_id'] = ['select your category\'s room'];
            
        }
        if(isset($_POST['check_in']) && !empty($_POST['check_in']))
        {
            $dataSuite=[ $_POST['check_in']];
        }
        else{
            $error['check_in'] = ['select the date of your arrival'];
            
        }
        if(isset($_POST['check_out']) && !empty($_POST['check_out']))
        {
            $dataSuite=[ $_POST['check_out']];
        }
        else{
            $error['check_out'] = ['select the date of your leaving'];
            
        }
        echo('<pre>');
        print_r($error);
        echo ('</pre>');
        if(isset($error) && !empty($error))
        {
            echo('ERROR DETECTER');
            echo('<br>');

            $modelRoom = new RoomModel();
            $rooms = $modelRoom -> getRooms(['cat_title']);
            echo('<pre>');
            print_r($data);
            echo ('</pre>');
            echo('<pre>');
            print_r($dataSuite);
            echo ('</pre>');
            // $model = new BookingModel;
            // $model -> newBooking($data);
            // $cust_id = $model -> getLastCustomerId();
            // $model2 = new BookingModel;
            // $model2 -> newBookingSuite($dataSuite);
            $this -> render('booking', [
                    'rooms' => $rooms,
                    'error' => $error
                ]);
            // redirect('/booking');
                // die;
        }
        else{
        
        $model = new BookingModel;
        $data = [
           $_POST['firstName'],
           $_POST['lastName'],
           $_POST['birthDate'],
           $_POST['email']
        ];
        echo('<pre>');
            print_r($data);
            echo ('</pre>');
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
            $_POST['check_in'],
            $_POST['check_out']

        ];
        
    $model2 -> newBookingSuite($dataSuite);
    
     
    redirect('/home');
        }
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
   
    
//         if(isset($_POST['firstName']) && !empty($_POST['firstName']))
//         if(isset($_POST['lastName']) && !empty($_POST['lastName']))
//         if(isset($_POST['email']) && !empty($_POST['email']))
//         if(isset($_POST['birthDate']) && !empty($_POST['birthDate']))
//         if(isset($_POST['check-in']) && !empty($_POST['check-in']))
//         if(isset($_POST['check-out']) && !empty($_POST['check-out']))
//         if(isset($_POST['cat_id']) && !empty($_POST['cat_id']))
//         {
//             $model = new BookingModel;
//             $data = [
//        $_POST['firstName'],
//        $_POST['lastName'],
//        $_POST['birthDate'],
//        $_POST['email'],
//             ];
//             $model2 = new BookingModel;
//             $cust_id = $model -> getLastCustomerId();
//             $dataSuite = [
//                 $cust_id,
//                 $_POST['cat_id'],
//                 $_POST['check-in'],
//                 $_POST['check-out']
//             ];

//     $model -> newBooking($data);
//     $model -> newBookingSuite([$dataSuite]);
//     redirect('/home');
//         }
//         else
//         {
//             throw new \Exception('Remplir tous les champs vide');
//         }
    
   
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
        
