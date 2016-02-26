<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

    require_once __DIR__."/../src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Stylist::deleteAll();
        }

        function test_allGetters()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;

            $stylist_test = new Stylist($name, $services, $phone, $id);

            $result1 = $stylist_test->getName();
            $result2 = $stylist_test->getServices();
            $result3 = $stylist_test->getPhone();

            $this->assertEquals($name, $result1);
            $this->assertEquals($services, $result2);
            $this->assertEquals($phone, $result3);

        }

        function test_getId()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = 1;

            $stylist_test = new Stylist($name, $services, $phone, $id);

            $result = $stylist_test->getId();

            $this->assertEquals($id, is_numeric($result));
        }

        function test_adjustPunctuation()
        {
            $name = "Marika";
            $services = "Cut/Style, Color, Men's Cut";
            $phone = "5032212348";
            $id = null;
            $test_stylist = new Stylist($name, $services, $phone, $id);

            $result = $test_stylist->adjustPunctuation($services);

            $this->assertEquals("Cut/Style, Color, Men\'s Cut", $result);
        }

        function test_save()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $result = Stylist::getAll();

            $this->assertEquals($stylist_test, $result[0]);
        }

        function test_getAll()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $name2 = "Mike";
            $services2 = "Cut/Style, Mens Cut";
            $phone2 = "971234903";
            $stylist_test2 = new Stylist($name2, $services2, $phone2, $id);
            $stylist_test2->save();

            $result = Stylist::getAll();

            $this->assertEquals([$stylist_test, $stylist_test2], $result);
        }

        function test_deleteAll()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $name2 = "Mike";
            $services2 = "Cut/Style, Mens Cut";
            $phone2 = "971234903";
            $stylist_test2 = new Stylist($name2, $services2, $phone2, $id);
            $stylist_test2->save();

            Stylist::deleteAll();
            $result = Stylist::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $name2 = "Mike";
            $services2 = "Cut/Style, Men's Cut";
            $phone2 = "971234903";
            $stylist_test2 = new Stylist($name2, $services2, $phone2, $id);
            $stylist_test2->save();

            $result = Stylist::find($stylist_test2->getId());

            $this->assertEquals($services2, $result->getServices());
        }

        function test_deleteStylist()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $name2 = "Mike";
            $services2 = "Cut/Style, Men's Cut";
            $phone2 = "971234903";
            $stylist_test2 = new Stylist($name2, $services2, $phone2, $id);
            $stylist_test2->save();

            $stylist_test2->delete();
            $result = Stylist::getAll();

            $this->assertEquals([$stylist_test], $result);
        }

        function test_update()
        {
            $name = "Gretchen Lou";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $new_name = "Gretchen Richardson";
            $new_services = "Cut/Style, Color, Highlights, Perm";
            $new_phone = "5033980234";

            $stylist_test->update($new_name, $new_services, $new_phone);
            $result = Stylist::find($stylist_test->getId());

            $this->assertEquals($new_name, $result->getName());

        }

        function test_getClients()
        {
            $name = "Gretchen Lou";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            
        }

    }





 ?>
