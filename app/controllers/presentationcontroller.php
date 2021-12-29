<?php

namespace TDW\Controllers;

class PresentationController extends AbstractController
{
    public function init()
    {
        echo '<title>VTC | Présentation</title>';
    }

    public function defaultAction()
    {
        $this->_view();
    }
}