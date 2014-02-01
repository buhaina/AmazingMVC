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

class Db {
    public function __construct() {

    }

    public function findAll($tableName, $modelClass)
    {
        $config = Amvc::app()->getConfiguration();

        $file =
            Amvc::app()->getBaseDir() .
            '/' . $config['paths']['data'] . '/' .
            $tableName . ".php";

        $reflect = new ReflectionClass($modelClass);

        $models = array();

        $dataRows = include($file);

        foreach ($dataRows as $dataRow) {
            $model = $reflect->newInstance();

            foreach ($dataRow as $dataAttributeKey => $dataAttributeValue) {

                $model->$dataAttributeKey = $dataAttributeValue;
            }

            $models[] = $model;
        }

        return $models;
    }

    public function findByPk($tableName, $modelClass, $id)
    {
        $allModels = $this->findAll($tableName, $modelClass);

        foreach ($allModels as $model) {
            if ($model->id == $id) {
                return $model;
            }
        }

        return null;
    }

    public function findByConditions($tableName, $modelClass, $conditions)
    {
        $models = array();

        $allModels = $this->findAll($tableName, $modelClass);

        foreach ($allModels as $model) {
            $conditionsOk = true;

            foreach ($conditions as $key => $value) {
                if ($model->$key != $value) {
                    $conditionsOk = false;
                    break;
                }
            }

            if ($conditionsOk) {
                $models[] = $model;
            }
        }

        return $models;
    }
} 