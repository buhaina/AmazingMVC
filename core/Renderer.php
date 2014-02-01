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

class Renderer {
    private $_view;

    const ERROR_PAGE = "error";
    const LAYOUT_BASE_DIRECTORY = "layout";

    public function __construct() {
    }

    public function render($page, $data) {
        $config = Amvc::app()->getConfiguration();

        if ($page != "error") {
            $pageDir =
                Amvc::app()->getBaseDir() .
                '/' . $config['paths']['view'] . '/' . $this->_view . '/';

            $pageFile = $pageDir . $page . ".php";
        }

        else $pageFile =
            Amvc::app()->getBaseDir() .
            '/' . $config['paths']['view'] . '/' . "error.php";

        $layoutDir =
            Amvc::app()->getBaseDir() .
            '/' . $config['paths']['view'] .
            '/' . self::LAYOUT_BASE_DIRECTORY . '/';

        include_once($layoutDir . "header.php");
        include_once($layoutDir . "navbar.php");
        include_once($layoutDir . "container.php");
        include_once($layoutDir . "footer.php");

        die();
    }

    public function setView($view) {
        $this->_view = $view;
    }

    public function renderError($errorMessage) {
        $this->render('error', $errorMessage);
    }
}