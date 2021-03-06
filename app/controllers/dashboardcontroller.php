<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Admin;
use TDW\Models\Content;
use TDW\Models\Diapo;
use TDW\Models\Poids;
use TDW\Models\Signal;

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
        if (!$this->isAdmin()) $this->redirect("/");
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
        if (!$this->isAdmin()) $this->redirect("/");
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
        if (!$this->isAdmin()) $this->redirect("/");
        $this->_data["signals"] = $_SESSION["admin"]->getSignals();
        $this->_view();
    }

    public function contentAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        $this->_data["content"] = Content::getPresentationContent();
        $this->_data["diapos"] = Diapo::getDiapos();
        if (isset($_POST["changeLink"])) {
            $id = $_POST["id"];
            $imageLink = $_POST["link"];
            if (Diapo::updateDiapo($id, $imageLink) == true) {
                $_SESSION["successMessage"] = "L'image est modifié";
            } else {
                $_SESSION["errorMessage"] = "L'image n'est pas modifié";
            }
        }
        $this->_view();
    }

    public function signaldetailsAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        if (!isset($this->_params[0])) $this->redirect("/notfound");
        $id = $this->_params[0];
        $this->_data["signal"] = Signal::getSignal($id);
        $this->_view();
    }

    public function updatecontentAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        if (!isset($this->_params[0])) $this->redirect("/notfound");
        $id = $this->_params[0];
        $this->_data["content"] = Content::getContentById($id);
        if (isset($_POST["submit"])) {
            $title = $this->filterString($_POST["title"]);
            $body = $this->filterString($_POST["body"]);
            $video = $this->filterString($_POST["video"]);
            $image = $this->filterString($_POST["image"]);
            $result = $this->_data["content"]->modifier($title, $body, $video, $image);
            if ($result) {
                $_SESSION["successMessage"] = "Le contenu est modifié";
                // $this->redirect("/dashboard");
            } else {
                $_SESSION["errorMessage"] = "Il y a un problème";
            }
        }
        $this->_view();
    }

    public function banclientAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        if (!isset($this->_params[0]) || !isset($this->_params[1])) $this->redirect("/notfound");
        $clientId = $this->_params[0];
        $decision = $this->_params[1];
        if ($_SESSION['admin']->banClient($clientId, $decision)) {
            $_SESSION["successMessage"] = 'L\'état du client est mis à jour';
        } else {
            $_SESSION["errorMessage"] = 'Il y a un problème';
        }
        $this->redirect("/dashboard");
    }

    public function bantransporteurAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        if (!isset($this->_params[0]) || !isset($this->_params[1])) $this->redirect("/notfound");
        $transporteurId = $this->_params[0];
        $decision = $this->_params[1];
        if ($_SESSION['admin']->banTransporteur($transporteurId, $decision)) {
            $_SESSION["successMessage"] = 'L\'état du transporteur est mis à jour';
        } else {
            $_SESSION["errorMessage"] = 'Il y a un problème';
        }
        $this->redirect("/dashboard");
    }

    public function demandesAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        $this->_data["clientDemandes"] = $_SESSION["admin"]->clientDoneDemandes();
        $this->_data["transporteursDemandes"] = $_SESSION["admin"]->transporteursDoneDemandes();
        $this->_view();
    }

    public function satisfaittransporteurAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        $id = $this->_params[0];
        echo $id;
        if ($_SESSION["admin"]->finishedClientDemande($id)) {
            $_SESSION["successMessage"] = "L'annonce est satisfait";
        } else {
            $_SESSION["errorMessage"] = "Il y a un problème";
        }
        $this->redirect("/dashboard/demandes");
    }

    public function satisfaitclientAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        $id = $this->_params[0];
        if ($_SESSION["admin"]->finishedTransporteurDemande($id)) {
            $_SESSION["successMessage"] = "L'annonce est satisfait";
        } else {
            $_SESSION["errorMessage"] = "Il y a un problème";
        }
        $this->redirect("/dashboard/demandes");
    }

    public function certificationAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        $this->_data["certifier"] = $_SESSION["admin"]->getCertificationDemandes();
        $this->_view();
    }

    public function verifierAction()
    {
        if (!$this->isAdmin()) $this->redirect("/");
        $id = $this->_params[0];
        $transporteurId = $this->_params[1];

        if ($_SESSION["admin"]->verifierTransporteur($id, $transporteurId)) {
            $_SESSION["successMessage"] = "Le transporteur est certifié";
        } else {
            $_SESSION["errorMessage"] = "Il y a un problème";
        }
        $this->redirect("/dashboard/certification");
    }
}