<?php
declare(strict_types=1);

namespace PHP82;

error_reporting(E_ERROR | E_WARNING | E_PARSE); ini_set('display_errors', '1');

$isFromSession = true;
$isElse= false;
require_once('./Addressbook.php');
require_once('./AddressbookEntry.php');
session_start();
if(isset($_SESSION) &&  isset($_SESSION["addressbook"])){
    $addressbook = $_SESSION["addressbook"];
    $isElse= true;
} else {
    require_once('./data.php');
    $isFromSession = false;
}

if(isset($_GET["load"])){
    require_once('./data.php');
}

$order = null;
$sort = null;
$linkSortOrder = "asc";

if(isset($_GET["sort"]) && isset($_GET["order"])){
    $sort = $_GET["sort"];
    $order = $_GET["order"];
    $addressbook->sort($_GET["sort"],$_GET["order"]);

    if($order ==="asc") {
        $linkSortOrder = "desc";
    } elseif ($order ==="desc") {
        $linkSortOrder = "asc";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Addressbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>

<h1><a href="index.php">Addressbook</a></h1>
<a href="index.php?load">load data</a>
<div class="container">
<form action="/PHP82/add.php" id="addressbookForm" method="post">
<div class="row">
    <div class="col-sm-3"><a href="/PHP82/index.php?sort=id&order=asc" class="sortlink" id="sortId" data-getsort=<?=$sort?> data-getorder=<?=$linkSortOrder?> data-sort="id" data-order="asc">Id</a></div>
    <div class="col-sm-3"><a href="/PHP82/index.php?sort=firstName&order=asc" class="sortlink" id="sortFirstname" data-getsort=<?=$sort?> data-getorder=<?=$linkSortOrder?>  data-sort="firstName" data-order="asc">Vorname</a></div>
    <div class="col-sm-3"><a href="/PHP82/index.php?sort=lastName&order=asc" class="sortlink" id="sortLastname" data-getsort=<?=$sort?> data-getorder=<?=$linkSortOrder?> data-sort="lastName" data-order="asc">Name</a></div>
    <div class="col-sm-3">Actions</div>
</div>
<?php foreach($addressbook->getEntries() as $key => $entry):?>
  <div class="row" id="row<?=$key?>">
    <div class="col-sm-3"> <input disabled type="text" name="id<?=$key?>" id="id<?=$key?>" value="<?=$entry->getId()?>"> </input></div>
    <div class="col-sm-3"><input disabled type="text" name="firstname<?=$key?>" id="firstname<?=$key?>" value="<?=$entry->getFirstName()?>"></input></div>
    <div class="col-sm-3"><input disabled type="text" name="lastname<?=$key?>" id="lastname<?=$key?>" value="<?=$entry->getLastName()?>"></input></div>
    <div class="col-sm-1">
        <div class="editsave">
            <div class="edit">
                <button class="edit" data-id=<?=$key?> name="edit<?=$key?>" id="edit<?=$key?>">edit</button>
            </div>
            <div class="save" style="display: none;">
                <button class="save" data-id=<?=$key?> name="save<?=$key?>" id="save<?=$key?>">save</button>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <button class="del" data-id=<?=$key?> name="del<?=$key?>" id="del<?=$key?>">del</button>
    </div>
  </div>
<?php endforeach;?>


</div>
<div class="row" style="margin-top: 5px;" id="addrow">
    <div class="col-sm-3"></div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3">
        <button class="add" name="add" id="add">add new</button>
    </div>
</div>
<button type="submit">submit</button>
</form>
<script src="addressbook.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

<h1>
</h1>
