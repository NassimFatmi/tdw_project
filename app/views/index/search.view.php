<?php
$defaultView = new TDW\VIEWS\Index\IndexView();
$defaultView->renderSearch();
$defaultView->renderSearchSection($this->_data['wilayas']);
$depart = \TDW\Models\Wilaya::getWilaya($this->_params[0])->getName();
$arrive = \TDW\Models\Wilaya::getWilaya($this->_params[1])->getName();
$defaultView->renderSearchList($this->_data['annonces'], $depart, $arrive);
