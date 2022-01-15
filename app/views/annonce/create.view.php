<?php
$annonceView = new \TDW\VIEWS\Annonce\AnnonceView();
$annonceView->renderCreate();

$wilayas = $this->_data['wilayas'];
$types = $this->_data['typesTransport'];
$poidsIntervals = $this->_data['poidsIntervals'];
$moyens = $this->_data['moyensTransport'];
$annonceView->renderForm($wilayas,$types,$poidsIntervals,$moyens);