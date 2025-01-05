<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class Contact


{
    
    public function sendEmail($title, $email, $description)
{
    $mail = new PHPMailer(true);

    try {
        // Mode debug de PHPMailer
        $mail->SMTPDebug = 2; // Active le mode debug (2 pour voir les détails complets)
        $mail->Debugoutput = 'html'; // Format HTML pour les logs

        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = getenv('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = getenv('MAIL_USERNAME');
        $mail->Password = getenv('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = getenv('MAIL_PORT');

        // Destinataire et expéditeur
        $mail->setFrom('zooarcadia2025@gmail.com', 'Zoo Arcadia');
        $mail->addAddress('zooarcadia2025@gmail.com', 'Zoo Arcadia');

        // Contenu du message
        $mail->isHTML(true);
        $mail->Subject = htmlspecialchars($title);
        $mail->Body    = "Demande de : <b>{$email}</b><br><br>" . nl2br(htmlspecialchars($description));
        $mail->AltBody = "Demande de : {$email}\n\n" . strip_tags($description);

        // Envoi du message
        $mail->send();
        echo 'Message envoyé avec succès !';
    } catch (Exception $e) {
        echo "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
    }
}



    


public function handleContactForm()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        $title = $_POST['titre'] ?? '';
        $email = $_POST['email'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($title) && !empty($email) && !empty($description)) {
            try {
                $this->sendEmail($title, $email, $description);

                // Ajouter un message de confirmation dans la session
                $_SESSION['success_message'] = 'Votre message a été envoyé avec succès !';

                // Redirection après succès
                header('Location: /ZooArcadia/contact/display');
                exit;
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur lors de l\'envoi : ' . $e->getMessage();

                // Redirection après échec
                header('Location: /ZooArcadia/contact/display');
                exit;
            }
        } else {
            $_SESSION['error_message'] = 'Veuillez remplir tous les champs du formulaire.';
            header('Location: /ZooArcadia/contact/display');
            exit;
        }
    }
}



    public function display()
    {
        // Logique pour afficher la page de contact
        return [
            'template' => 'contact', // Assurez-vous que le fichier `contact.php` existe dans `templates/`
            'message' => 'Nous contacter'
        ];
    }
}
