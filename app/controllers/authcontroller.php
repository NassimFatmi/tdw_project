<?php

namespace TDW\Controllers;


use TDW\LIB\Helper;
use TDW\Models\AbstractModel;
use TDW\Models\Adresse;
use TDW\Models\Client;
use TDW\Models\Trajet;
use TDW\Models\Transporteur;
use TDW\LIB\InputFilter;
use TDW\Models\Wilaya;

class AuthController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function init()
    {
        echo '<title>VTC | Auth</title>';
    }

    public function loginAction()
    {

        if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true) {
            $this->redirect('/');
            exit;
        }
        if (isset($_POST["submit"])) {
            $email = trim($this->filterString($_POST["email"]));
            $password = trim($this->filterString($_POST["password"]));
            if (isset($_POST["accountType"])) {
                $user = Transporteur::login($email, $password);
            } else {
                $user = Client::login($email, $password);
            }
            if (!$user) {
                $_SESSION["errorMessage"] = "Les informations sont incorecte ou l'utilisateur n'éxiste pas.";
            } else {
                $_SESSION["isAuth"] = true;
                $_SESSION["user"] = $user;
                $this->redirect('/');
            }
        }
        $this->_view();
    }

    public function registerAction()
    {
        $this->_data['wilayas'] = Wilaya::getWillayas();

        if (isset($_SESSION["isAuth"]) && $_SESSION["isAuth"] === true) {
            $this->redirect('/');
        }

        if (isset($_POST["submit"])) {
            // User general information
            $nom = trim($this->filterString($_POST["nom"]));
            $prenom = trim($this->filterString($_POST["prenom"]));
            $email = trim($this->filterString($_POST["email"]));
            $password = trim($this->filterString($_POST["password"]));
            $phone = trim($this->filterString($_POST["phone"]));

            // User adresse
            $adresse = trim($this->filterString($_POST["adr"]));
            $commune = trim($this->filterString($_POST["commune"]));
            $wilayaCode = trim($this->filterString($_POST["wilaya"]));

            $userAdresse = new Adresse($commune, $adresse, $wilayaCode);

            if (isset($_POST["isTransporteur"])) {
                if (!isset($_POST['trajets'])) {
                    return;
                }
                $trajetsArray = $_POST['trajets'];
                $userTrajets = Trajet::buildTrajets($trajetsArray);
                $user = new Transporteur($nom, $prenom, $email, $phone, $userAdresse);
                $user->setTrajets($userTrajets);
            } else {
                $user = new Client($nom, $prenom, $email, $phone, $userAdresse);
            }

            if ($user->exists($email)) {
                $_SESSION["errorMessage"] = 'Utilisateur déja exister, Essayer de se connecter';
                $this->redirect('/auth/login');
            }
            if ($user->register($password)) {
                unset($_SESSION["errorMessage"]);
                $this->redirect('/auth/login');
            } else {
                $_SESSION["errorMessage"] = 'Il y a un probleme';
            }
        }
        $this->_view();
    }

    public function logoutAction()
    {
        unset($_SESSION["isAuth"]);
        unset($_SESSION["user"]);
        $this->redirect('/');
    }
}