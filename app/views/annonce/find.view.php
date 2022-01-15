<?php
$findView = new \TDW\VIEWS\Annonce\AnnonceView();
$findView->renderFind();
$findView->renderFindSection($this->_data['annonce'], $this->_data['transporteurs']);