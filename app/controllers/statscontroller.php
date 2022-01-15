<?php

namespace TDW\Controllers;

use TDW\Models\Annonce;
use TDW\Models\Client;
use TDW\Models\Transporteur;

class StatsController extends AbstractController
{
    public function init()
    {
        echo '<title>VTC | Statistiques</title>';
        echo '<link href="/css/stats.css" rel="stylesheet">';
    }

    public function defaultAction()
    {
        $this->_data['clientNumber'] = Client::getNumberOfclients();
        $this->_data['transporteurNumber'] = Transporteur::getNumberOfTransporteurs();
        $this->_data['annonceNumber'] = Annonce::getAnnonceNumber();
        $this->_data['finishedAnnonceNumber'] = Annonce::getAnnonceFinished();
        $this->_view();
    }
}