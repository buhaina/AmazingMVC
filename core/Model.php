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

class Model {
    private $_data;

    public function findAll() {
        return Amvc::app()->getDb()->findAll($this->tableName(), $this->className());
    }

    public function __construct() {
        $this->_data = array();

        foreach ($this->properties() as $property) {
            $this->_data[$property] = '';
        }
    }

    public function __get($name) {
        if (!$this->hasProperty($name)) throw new Exception("No such property: " . $name);
        return $this->_data[$name];
    }

    public function __set($name, $value) {
        if (!$this->hasProperty($name)) throw new Exception("No such property: " . $name);
        $this->_data[$name] = $value;
    }

    protected function properties() {
        return array(

        );
    }

    protected function tableName() {
        return 'sdsd';
    }

    protected function className() {
        return __CLASS__;
    }

    private function hasProperty($propertyName) {
        return isset($this->_data[$propertyName]);
    }
}