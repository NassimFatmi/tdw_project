<?php

namespace TDW\Controllers;

use TDW\LIB\Database\Database;
use TDW\LIB\FrontController;
use TDW\Templates\Templates;

class AbstractController
{
    protected $_controller;
    protected $_action;
    protected $_params;
    protected $_data = [];

    public function notFoundAction()
    {
        $this->_view();
    }

    public function setController($controllerName)
    {
        $this->_controller = $controllerName;
    }

    public function setAction($actionName)
    {
        $this->_action = $actionName;
    }

    public function setParams($params)
    {
        $this->_params = $params;
    }

    protected function _view()
    {
        if ($this->_action == FrontController::NOT_FOUND_ACTION) {
            require_once VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
        } else {
            $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
            if (file_exists($view)) {
                extract($this->_data);

                Templates::headerStart();
                if (method_exists($this, 'init')) {
                    $this->init();
                }
                Templates::headerEnd();
                require_once $view;
                Templates::templateFooter();
                if (method_exists($this, 'scripts')) {
                    $this->scripts();
                }
                Templates::fileEnd();
            } else {
                require_once VIEWS_PATH . 'notfound' . DS . 'noview.view.php';
            }
        }
    }
}