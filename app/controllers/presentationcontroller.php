<?php

namespace TDW\Controllers;

class PresentationController extends AbstractController
{
    public function defaultAction () {
        $this->_view();
    }
}