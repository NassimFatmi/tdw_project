<?php

namespace TDW\Controllers;

class IndexController extends AbstractController
{
    public function init () {
        echo '<link href="css/slider.css" rel="stylesheet">';
        echo '<title>VTC | Accueil</title>';
    }
    public function scripts () {
        echo '<script src = "js/slider.js" ></script >';
    }
    public function defaultAction()
    {
        $this->_view();
    }

    public function addAction()
    {
        $this->_view();
    }
}