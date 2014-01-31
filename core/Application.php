<?php
// This file is part of AmazingMVC.
// Copyright (C) 2014 Miika Pelkonen
//
// AmazingMVC is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// AmazingMVC is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with AmazingMVC.  If not, see <http://www.gnu.org/licenses/>.

include_once("Controller.php");
include_once("Renderer.php");
include_once("Db.php");
include_once("Model.php");

class Application {
    const CONTROLLER_FILE_NAME = "Controller.php";
    const CONTROLLER_CLASS_NAME = "Controller";
    const CONTROLLER_ACTION_PREFIX = "action";

    private $_renderer;
    private $_configuration;
    private $_db;

    /**
     * Constructor. Constructs application with configuration.
     *
     * @param $configurationFileName
     */
    public function __construct($configurationFileName) {
        // read configuration
        include_once($configurationFileName);

        if (!isset($configuration)) {
            die("invalid configuration file");
        }
        else {
            $this->_configuration = $configuration;
        }

        // initialize renderer
        $this->_renderer = new Renderer($this);

        // initialize
        $this->_db = new Db();

        // include models
        $this->includeModels();
    }

    /**
     * Runs the application.
     */
    public function run() {
        if (empty($_REQUEST)) $request = array('r' => $this->_configuration['indexPage']);
        else $request = $_REQUEST;

        $requestTokens = explode('/', $request['r']);

        $this->_renderer->setView($requestTokens[0]);

        $controller = $this->createController($requestTokens[0]);
        $action =  self::CONTROLLER_ACTION_PREFIX . ucfirst($requestTokens[1]);
        $params = $_REQUEST;
        unset($params['r']);

        $this->doAction($controller, $action, $params);
    }

    /**
     * Gets configuration.
     *
     * @return array configuration
     */
    public function getConfiguration() {
        return $this->_configuration;
    }

    /**
     * @return Renderer renderer
     */
    public function getRenderer() {
        return $this->_renderer;
    }

    /**
     * @return string URL
     */
    public function getUrl($urlString) {
        return "index.php?r=" . $urlString;
    }

    /**
     * @return Db db
     */
    public function getDb() {
        return $this->_db;
    }

    /**
     * @param $controllerString
     * @return Controller controller
     */
    private function createController($controllerString) {
        $controllerPrefix = ucfirst($controllerString);

        $controllerFile = getcwd() .
            '/' . $this->_configuration['paths']['controller'] . '/' .
            $controllerPrefix .
            self::CONTROLLER_FILE_NAME;

        if (!file_exists($controllerFile)) $this->renderError();
        include_once($controllerFile);

        $reflect = new ReflectionClass($controllerPrefix . self::CONTROLLER_CLASS_NAME);
        return $reflect->newInstance();
    }

    private function doAction($controller, $actionString, $params) {
        if (!method_exists($controller, $actionString)) $this->renderError();

        $controller->{$actionString}($params);
    }

    private function renderError() {
        $this->_renderer->renderError("The requested page does not exist.");
    }

    private function includeModels() {
        $modelPath =
            getcwd() .
            '/' . $this->_configuration['paths']['model'] . '/';

        $allFiles = scandir($modelPath);

        foreach ($allFiles as $file) {
            if (preg_match("/.php$/", $file) == 1) {
                include_once($modelPath . $file);
            }
        }
    }
}