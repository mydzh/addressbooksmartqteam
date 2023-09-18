<?php

declare(strict_types=1);

namespace PHP82;

error_reporting(E_ERROR | E_WARNING | E_PARSE); ini_set('display_errors', '1');


require_once('./Addressbook.php');
require_once('./AddressbookEntry.php');


$addressbook = new Addressbook();
$entry = new AddressbookEntry("Tom","Tomson");

$addressbook->addEntry(
    $entry
);
$addressbook->addEntry(
    new AddressbookEntry("Jack","Jonson")
);
$addressbook->addEntry(
    new AddressbookEntry("Anis","Aniston")
);

$_SESSION["addressbook"] = $addressbook;
?>
