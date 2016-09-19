<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Inventory.php";

    $server = 'mysql:host=localhost;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class IventoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Inventory::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $item = "Television";
            $test_Category = new Inventory($item);

            //Act
            $result = $test_Category->getItem();

            //Assert
            $this->assertEquals($item, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Inventory($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Inventory($name);
            $test_Category->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Inventory($name);
            $test_Category->save();
            $test_Category2 = new Inventory($name2);
            $test_Category2->save();

            //Act
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Inventory($name);
            $test_Category->save();
            $test_Category2 = new Inventory($name2);
            $test_Category2->save();

            //Act
            Inventory::deleteAll();
            $result = Inventory::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //ArraInventorynge
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $test_Category = new Inventory($name);
            $test_Category->save();
            $test_Category2 = new Inventory($name2);
            $test_Category2->save();

            //Act
            $result = Inventory::find($test_Category->getItem());

            //Assert
            $this->assertEquals($test_Category, $result);
        }
    }

?>
