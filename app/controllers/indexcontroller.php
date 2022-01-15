<?php

namespace TDW\Controllers;

use TDW\LIB\Helper;
use TDW\LIB\InputFilter;
use TDW\Models\Annonce;
use TDW\Models\News;
use TDW\Models\Wilaya;

class IndexController extends AbstractController
{
    use InputFilter;
    use Helper;

    public function init()
    {
        echo '<link href="/css/slider.css" rel="stylesheet">';
        echo '<title>VTC | Accueil</title>';
    }

    public function scripts()
    {
        echo '<script src = "js/slider.js" ></script >';
    }

    public function defaultAction()
    {
        $this->_data['wilayas'] = Wilaya::getWillayas();
        $annonces = Annonce::getRandomAnnonce();
        $this->_data['annonces'] = $annonces ? $annonces : [];
        $this->_data['news'] = News::getNews(4, 0);
        if (isset($_POST['submit'])) {
            $wilayaDepart = trim($this->filterInt($_POST["wilayaDepart"]));
            $wilayaArrive = trim($this->filterInt($_POST["wilayaArrive"]));
            $this->redirect('/index/search/' . $wilayaDepart . '/' . $wilayaArrive);
        }
        $this->_view();
    }

    public function searchAction()
    {
        $this->_data['wilayas'] = Wilaya::getWillayas();
        if (isset($_POST['submit'])) {
            $wilayaDepart = trim($this->filterInt($_POST["wilayaDepart"]));
            $wilayaArrive = trim($this->filterInt($_POST["wilayaArrive"]));
            $this->redirect('/index/search/' . $wilayaDepart . '/' . $wilayaArrive);
        }
        if (!isset($this->_params[0]) || !isset($this->_params[1])) $this->redirect('/notfound');
        if (!is_numeric($this->_params[0]) || !is_numeric($this->_params[1])) $this->redirect('/notfound');
        $this->_data['annonces'] = Annonce::searchAnnonce($this->_params[0],$this->_params[1]);
        $this->_view();
    }
}