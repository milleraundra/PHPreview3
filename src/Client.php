<?php

    class Client {

        private $client;
        private $number;
        private $stylist_id;
        private $id;

        function __construct($client, $number, $stylist_id, $id = null)
        {
            $this->client = $client;
            $this->number = $number;
            $this->stylist_id = $stylist_id;
            $this->id = $id;
        }

        function setClient($new_client)
        {
            $this->client = $new_client;
        }

        function getClient()
        {
            return $this->client;
        }

        function setNumber($new_number)
        {
            $this->number = $new_number;
        }

        function getNumber()
        {
            return $this->number;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients(name, phone, stylist_id) VALUES ('{$this->getClient()}', '{$this->getNumber()}', {$this->getStylistId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client){
                $client_name = $client['name'];
                $client_number = $client['phone'];
                $client_stylist_id = $client['stylist_id'];
                $client_id = $client['id'];
                $new_client = new Client($client_name, $client_number, $client_stylist_id, $client_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients");
        }

        static function find($id)
        {
            $all_clients = Client::getAll();
            $matching_client = null;
            foreach($all_clients as $client) {
                $client_id = $client->getId();
                if($client_id == $id) {
                    $matching_client = $client;
                }
            }
            return $matching_client;
        }

        function update($new_client, $new_number)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name ='{$new_client}', phone ='{$new_number}' WHERE id={$this->getId()};");
            $this->setClient($new_client);
            $this->setNumber($new_number);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id={$this->getId()};");
        }

    }




?>
