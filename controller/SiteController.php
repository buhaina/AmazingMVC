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

class SiteController extends Controller {
    public function actionHome($params) {
        $this->application->getRenderer()->render('home', "heeeeee");
    }

    public function actionPersons($params) {
        $person1 = new Person();

        $person1->name = "Foo";
        $person1->age = 24;
        $person1->address = "BarStreet 32";

        $person2 = new Person();

        $person2->name = "Bar";
        $person2->age = 30;
        $person2->address = "FooStreet 64";

        $persons = array($person1, $person2);

        $this->render('persons', $persons);

    }
} 