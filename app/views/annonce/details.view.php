<?php
$detailsView = new \TDW\VIEWS\Annonce\AnnonceView();
$detailsView->renderDetails();
$detailsView->annonceDetails($this->_data['annonce'],$this->_data['annonceClient']);