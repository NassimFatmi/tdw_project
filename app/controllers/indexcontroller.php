<?php

namespace TDW\Controllers;

use TDW\Models\Annonce;

class IndexController extends AbstractController
{
    public function init()
    {
        echo '<link href="css/slider.css" rel="stylesheet">';
        echo '<title>VTC | Accueil</title>';
    }

    public function scripts()
    {
        echo '<script src = "js/slider.js" ></script >';
    }

    public function defaultAction()
    {
        $annonces = Annonce::getRandomAnnonce();
        $this->_data['annonces'] = $annonces ? $annonces : [];
        $this->_view();
    }

    public function addAction()
    {
        $this->_view();
    }
}