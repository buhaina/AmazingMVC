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

/* @var $data
 * @var $person Person
 *
 */
?>

<h1>Persons</h1>
<table class="table">
    <tr>
        <th>
            Name
        </th>
        <th>
            Age
        </th>
        <th>
            Address
        </th>
    </tr>
    <tr>

        <?php

foreach ($data as $person) {
    echo "<tr>";
    echo "<td>" . $person->name . "</td>";
    echo "<td>" . $person->age . "</td>";
    echo "<td>" . $person->address . "</td>";
    echo "</tr>";
}

?>
</table>