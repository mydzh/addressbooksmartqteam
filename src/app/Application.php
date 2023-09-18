<?php

namespace App;

class Application
{
    public function run()
    {
        $addressbook = $this->loadFirstAddressbook();

        $isFromSession = true;
        $isElse= false;

        session_start();
        if(isset($_SESSION) &&  isset($_SESSION["addressbook"])){
            $addressbook = $_SESSION["addressbook"];
            $isElse= true;
        } else {
            $isFromSession = false;
            $_SESSION["addressbook"] = $addressbook;
        }

        if(isset($_GET["load"])){
            $addressbook = $this->loadFirstAddressbook();
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

        echo $this->view("template",[
            "addressbook" => $addressbook,
            "linkSortOrder" => $linkSortOrder,
            "sort" => $sort,
        ]);
    }

    public function add()
    {
        session_start();
        $data = json_decode(file_get_contents('php://input'), true);

        if(isset($_SESSION["addressbook"]) && $_SESSION["addressbook"]) {
            $addressbookNew = new Addressbook();
            $addressbookNew = $_SESSION["addressbook"];

            $newEntry = new AddressbookEntry($data["firstname"],$data["lastname"]);
            $newEntry->setId(intval($data["id"]));
            $newEntry = $addressbookNew->addEntry($newEntry);
            $_SESSION["addressbook"] =  $addressbookNew;

            $_SESSION["id"] = $data["id"];
            $_SESSION["lastname"] = $data["lastname"];

            echo json_encode(["id"=>$newEntry->getId()]);
        } else {
            $addressbook = $this->loadFirstAddressbook();
            $_SESSION["addressbook"] = $addressbook;
        }
    }

    public function del() {
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
    }
    
    public function edit(){
        session_start();
        $data = json_decode(file_get_contents('php://input'), true);

        if($_SESSION["addressbook"]) {
            $addressbookNew = new Addressbook();
            $addressbookNew = $_SESSION["addressbook"];
            $newEntry = new AddressbookEntry($data["firstname"],$data["lastname"]);
            $newEntry->setId(intval($data["id"]));
            $addressbookNew->editEntry($newEntry);
            $_SESSION["addressbook"] =  $addressbookNew;
            $_SESSION["id"] = $data["id"];
            $_SESSION["lastname"] = $data["lastname"];
        }
    }

    private function loadFirstAddressbook() {
        $addressbook = new Addressbook();
        $entry = new AddressbookEntry("Tom","Tomson");

        $addressbook->addEntry(
            $entry
        );
        $addressbook->addEntry(
            new AddressbookEntry("Jack","Jonson")
        );
        $addressbook->addEntry(
            new AddressbookEntry("Elis","Aniston")
        );
        return $addressbook;
    }

    private function view($file, $vars) {
        ob_start();
        extract($vars);
        include dirname(__FILE__) . '/view/' . $file . '.php';
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
}

?>
