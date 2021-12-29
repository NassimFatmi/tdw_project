<?php

namespace TDW\Controllers;

use TDW\Models\Annonce;
use TDW\Models\News;

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
        $this->_data['news'] = News::getNews(4,0);
        $this->_view();
    }

    public function addAction()
    {
        $this->_view();
    }
}