<?php

namespace TDW\Controllers;

class ProfileController extends AbstractController
{
    public function init()
    {
        echo '<title>VTC | Profile</title>';
    }

    public function defaultAction () {
        $this->_view();
    }
}