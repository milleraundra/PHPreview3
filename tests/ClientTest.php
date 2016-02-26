<?php

/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase {

        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_allGetters()
        {
            $client = "Mary Smith";
            $number = "5033042348";
            $stylist_id = 3;
            $id = null;
            $test_client = new Client($client, $number, $stylist_id, $id);

            $result = $test_client->getClient();
            $result2 = $test_client->getNumber();
            $result3 = $test_client->getStylistId();

            $this->assertEquals($client, $result);
            $this->assertEquals($number, $result2);
            $this->assertEquals($stylist_id, $result3);
        }
        function test_getId()
        {
            $client = "Mary Smith";
            $number = "5033042348";
            $stylist_id = null;
            $id = 1;
            $test_client = new Client($client, $number, $stylist_id, $id);

            $result = $test_client->getId();

            $this->assertEquals($id, is_numeric($result));
        }

        function test_save()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $client = "Mary Smith";
            $number = "5033042348";
            $stylist_id = $stylist_test->getId();
            $client_test = new Client($client, $number, $stylist_id, $id);
            $client_test->save();

            $result = Client::getAll();

            $this->assertEquals([$client_test], $result);
        }

        function test_getAll()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $client = "Mary Smith";
            $number = "5033042348";
            $stylist_id = $stylist_test->getId();
            $client_test = new Client($client, $number, $stylist_id, $id);
            $client_test->save();

            $client2 = "Jack Snider";
            $number2 = "521234234";
            $client_test2 = new Client($client2, $number2, $stylist_id, $id);
            $client_test2->save();

            $result = Client::getAll();

            $this->assertEquals([$client_test, $client_test2], $result);
        }

        function test_deleteAll()
        {
            $name = "Gretchen";
            $services = "Cut/Style, Color, Highlights";
            $phone = "5033902341";
            $id = null;
            $stylist_test = new Stylist($name, $services, $phone, $id);
            $stylist_test->save();

            $client = "Mary Smith";
            $number = "5033042348";
            $stylist_id = $stylist_test->getId();
            $client_test = new Client($client, $number, $stylist_id, $id);
            $client_test->save();

            $client2 = "Jack Snider";
            $number2 = "521234234";
            $client_test2 = new Client($client2, $number2, $stylist_id, $id);
            $client_test2->save();

            Client::deleteAll();
            $result = Client::getAll();

            $this->assertEquals([], $result);
        }
    }



?>
