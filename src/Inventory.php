<?php
class Inventory
{
    private $item;
    private $id;
    private $description;
    private $value;

//Constructor
    function __construct($item, $id = null, $description=null, $value=null)
    {
        $this->item = $item;
        $this->id = $id;
        $this->description = $description;
        $this->value = $value;
    }
    function getId(){
        return $this->id;
    }

//Getter and Setters
    function setItem($new_item)
    {
        $this->item = (string) $new_item;
    }

    function getItem()
    {
        return $this->item;
    }
    // function setDescription($new_description)
    // {
    //     $this->description = (string) $new_description;
    // }
    //
    // function getDescription()
    // {
    //     return $this->description;
    // }
    // function setValue($new_value)
    // {
    //     $this->value = (string) $new_value;
    // }
    //
    // function getValue()
    // {
    //     return $this->value;
    // }

//Regular Methods
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO inventory (item) VALUES ('{$this->getItem()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

//Static Methods

    static function getAll()
        {
        $returned_items = $GLOBALS['DB']->query("SELECT * FROM inventory;");
        $items = array();
        foreach($returned_items as $item) {
            $item_name = $item['item'];
            $id = $item['id'];
            $new_item = new Inventory($item_name, $id);
            array_push($items, $new_item);
        }
        return $items;
    }

    static function deleteAll()
   {
       $GLOBALS['DB']->exec("DELETE FROM inventory;");
   }
   static function find($search_name)
    {
        $found_item = null;
        $items = Inventory::getAll();
        foreach($items as $item) {
            $item_name = $item->getItem();
            if ($item_name == $search_name) {
                $found_item = $item;
            }
        }
        return $found_item;
    }

}
?>
