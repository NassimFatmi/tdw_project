<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;

class DashboardController extends AbstractController
{
    use Helper;
    use InputFilter;

    public function init()
    {
        echo '<title>VTC | Admin</title>';
        echo '<link href="/css/admin.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        $this->_view();
    }

    public function annoncesAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $filters = [];
        if (isset($_POST["submit"])) {
            if (isset($_POST["verifier"])) {
                $filters["verifier"] = 1;
            }
            if (isset($_POST["finished"])) {
                $filters["finished"] = 1;
            }
            if (isset($_POST["archive"])) {
                $filters["archive"] = 1;
            }
        }
        $this->_data["annonces"] = $_SESSION["admin"]->getAllAnnonces(20, 0, $filters);
        $this->_view();
    }

    public function verifierannonceAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $this->_data["annonceId"] = $this->_params[0];
        if (isset($_POST["submit"])) {
            $annonceId = $this->_params[0];
            $prix = $this->filterInt($_POST["prix"]);
            if ($_SESSION["admin"]->verifyAnnonce($annonceId, $prix)) {
                $_SESSION["successMessage"] = "L'annonce est vérifiée";
                $this->redirect("/dashboard");
            } else {
                $_SESSION["errorMessage"] = "Il ya un probleme";
            }
        }
        $this->_view();
    }

    public function deleteannonceAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $annonceId = $this->_params[0];
        if ($_SESSION["admin"]->archiveAnnonce($annonceId)) {
            $_SESSION["successMessage"] = "L'annonce est supprimée";
        } else {
            $_SESSION["errorMessage"] = "Il ya un probleme";
        }
        $this->redirect("/dashboard");
    }

    public function clientsAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $this->_data["clients"] = $_SESSION["admin"]->getClients(20, 0);
        $this->_view();
    }

    public function transporteursAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $this->_data["transporteurs"] = $_SESSION["admin"]->getTransporteurs(20, 0);
        $this->_view();
    }

    public function logoutAction()
    {
        unset($_SESSION["admin"]);
        $this->redirect("/");
    }

    public function newsAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $this->_data["news"] = $_SESSION["admin"]->getNews(20, 0);
        $this->_view();
    }

    public function deletenewsAction()
    {
        if (!$this->isAdmin()) $this->redirect("/auth/admin");
        $newsId = $this->_params[0];
        if ($_SESSION["admin"]->deleteNews($newsId)) {
            $_SESSION["successMessage"] = "L'annonce est vérifiée";
            $this->redirect("/dashboard");
        } else {
            $_SESSION["errorMessage"] = "Il ya un probleme";
        }
    }

    public function createnewsAction()
    {
        if (isset($_POST['submit'])) {
            $fileSize = $_FILES['file']['size'];
            if ($fileSize < 5000000) {

                $title = $this->filterString($_POST["title"]);
                $summary = $this->filterString($_POST["summary"]);
                $article = $this->filterString($_POST["article"]);

                $result = $_SESSION["admin"]->createNews($title, $summary, $article);
                if ($result) {
                    $_SESSION['successMessage'] = "Votre news a été publier";
                    $this->redirect('/dashboard');
                } else {
                    $_SESSION['errorMessage'] = 'Il y a un probleme essayer plus tard';
                }
            } else {
                $_SESSION['errorMessage'] = 'Votre fichier est trop large.';
            }
        }
        $this->_view();
    }

    public function signalsAction()
    {
        $this->_data["signals"] = $_SESSION["admin"]->getSignals();
        $this->_view();
    }

    public function contentAction()
    {
        $this->_view();
    }
}