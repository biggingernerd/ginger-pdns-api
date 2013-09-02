<?php

$dbh = new PDO('mysql:host=localhost;dbname=powerdns', "root", "gluyo4bo");

Registry::set('DB', $dbh);