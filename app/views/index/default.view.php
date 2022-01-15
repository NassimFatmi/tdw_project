<?php
$defaultView = new TDW\VIEWS\Index\IndexView();
$defaultView->renderDefault();
$defaultView->renderSearchSection($this->_data['wilayas']);
$defaultView->renderTrend($this->_data['annonces']);
$defaultView->renderLatestNews($this->_data['news']);