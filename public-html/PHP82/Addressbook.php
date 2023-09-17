<?php

namespace PHP82;

//use AddressbookEntry;

class Addressbook
{
    private array $entries;

    public function setEntries(array $firstName)
    {
        $this->firstName = $firstName;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function addEntry(AddressbookEntry $entry): AddressbookEntry
    {
        $this->entries[] = $entry;
        $entry->setId(array_key_last($this->entries));

        return $entry;
    }
    
    public function editEntry(AddressbookEntry $entry): void
    {
        $this->entries[$entry->getId()] = $entry;
    }

    public function deleteEntry(AddressbookEntry $entry): void
    {
        unset($this->entries[$entry->getId()]);
    }

    public function sort(string $field, string $order): void
    {
        if ($field ==="id"){
            if($order === "desc") {
                usort($this->entries, fn($b, $a) =>
                intval($a->{'get' . ucfirst($field)}()) - intval($b->{'get' . ucfirst($field)}()));    
            } else {
                usort($this->entries, fn($a, $b) =>
                intval($a->{'get' . ucfirst($field)}()) - intval($b->{'get' . ucfirst($field)}()));    
            }
        } else {
            if($order === "desc") {
                usort($this->entries, fn($b, $a) =>
                strcasecmp($a->{'get' . ucfirst($field)}(), $b->{'get' . ucfirst($field)}()));  
            } else {
                usort($this->entries, fn($a, $b) =>
                strcasecmp($a->{'get' . ucfirst($field)}(), $b->{'get' . ucfirst($field)}()));  
            }
        }
    }
    
    public function sortIntStringAsc($a, $b)
    {
        return intval($a['order']) - intval($b['order']);
    }
    
    public function sortIntStringDesc($a, $b)
    {
        return intval($b['order']) - intval($a['order']);
    }

    public function __construct(array $entries =[])
    {
        $this->entries = $entries;
    }
}

?>
