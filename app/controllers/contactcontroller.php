<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;

class ContactController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function init()
    {
        echo '<title>VTC | Contactez-Nous</title>';
        echo '<link href="/css/contact.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        if(!$this->isAuthenticated()) $this->redirect("/auth/login");
        if(isset($_POST["submit"])) {
            $email = $this->filterString($_POST["email"]);
            $objet = $this->filterString($_POST["objet"]);
            $message = $this->filterString($_POST["message"]);
            if($_SESSION["user"]->contactAdmin($email,$objet, $message)) {
                $_SESSION["successMessage"] = "Votre message a été envoyer";
            } else {
                $_SESSION["errorMessage"] = "Votre message n'a été pas envoyer";
            }
            $this->redirect("/");
        }
        $this->_view();
    }
}