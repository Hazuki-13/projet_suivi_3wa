<?php

namespace Controllers;

class Controller
{
    public function render(string $template, array $variables = []): void
    {
        /* la méthode "render" evite de répéter le code suivant dans mes controlleurs
        ** $template =  'home' ;
        **require 'Views/layout.phtml';
        */
        extract($variables);
        require 'Views/layout.phtml';
    }
}
        
