<?php
declare(strict_types=1);

namespace PHP82;

error_reporting(E_ERROR | E_WARNING | E_PARSE); ini_set('display_errors', '1');

require_once('./Addressbook.php');
require_once('./AddressbookEntry.php');
session_start();

$data = json_decode(file_get_contents('php://input'), true);


if($_SESSION && $_SESSION["addressbook"]) {
    $addressbookNew = new Addressbook();
    $addressbookNew = $_SESSION["addressbook"];

    $newEntry = new AddressbookEntry($data["firstname"],$data["lastname"]);
    $newEntry->setId(intval($data["id"]));
    $addressbookNew->deleteEntry($newEntry);
    $_SESSION["addressbook"] =  $addressbookNew;

    echo json_encode(["status"=> "ok"]);
}
?>
