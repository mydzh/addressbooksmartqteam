<?php
declare(strict_types=1);

namespace PHP82;

error_reporting(E_ERROR | E_WARNING | E_PARSE); ini_set('display_errors', '1');

require_once('./Addressbook.php');
require_once('./AddressbookEntry.php');
session_start();
//require_once('/var/www/html/php82/data.php');
//var_dump($_SERVER);
//var_dump("post: ", $_POST);
//var_dump("get: ", $_GET);
$data = json_decode(file_get_contents('php://input'), true);

if($_SESSION["addressbook"]) {
    $addressbookNew = new Addressbook();
    $addressbookNew = $_SESSION["addressbook"];
    //var_dump("session: ",$_SESSION["addressbook"]);
    $newEntry = new AddressbookEntry($data["firstname"],$data["lastname"]);
    $newEntry->setId(intval($data["id"]));
    $newEntry = $addressbookNew->addEntry($newEntry);
    $_SESSION["addressbook"] =  $addressbookNew;
    //var_dump("session: ",$_SESSION["addressbook"]);
    $_SESSION["id"] = $data["id"];
    $_SESSION["lastname"] = $data["lastname"];

    echo json_encode(["id"=>$newEntry->getId()]);
}
?>
