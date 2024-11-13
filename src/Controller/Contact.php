<?php

namespace App\Controller;

class Contact
{
    public function display()
    {
        // Logique pour afficher la page des habitats
        return [
            'template' => 'contact', // ou autre nom selon votre template
            'message' => 'Nous contacter'
        ];
    }
}