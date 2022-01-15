<?php

namespace TDW\Controllers;

class PresentationController extends AbstractController
{
    public function init()
    {
        echo '<title>VTC | Présentation</title>';
        echo '<link href="/css/presentation.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        $this->_view();
    }
}