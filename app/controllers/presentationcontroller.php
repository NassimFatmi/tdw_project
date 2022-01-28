<?php

namespace TDW\Controllers;

use TDW\Models\Content;

class PresentationController extends AbstractController
{
    public function init()
    {
        echo '<title>VTC | Présentation</title>';
        echo '<link href="/css/presentation.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        $this->_data["content"] = Content::getPresentationContent();
        $this->_view();
    }
}