<?php

    class Stylist
    {
        private $name;
        private $services;
        private $phone;
        private $id;

        function __construct($name, $services, $phone, $id = null)
        {
            $this->name = $name;
            $this->services = $services;
            $this->phone = $phone;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setServices($new_services)
        {
            $this->services = $new_services;
        }

        function getServices()
        {
            return $this->services;
        }

        function setPhone($new_phone)
        {
            $this->phone = $new_phone;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function getId()
        {
            return $this->id;
        }

        function adjustPunctuation($input)
        {
            $search = "/(\')/";
            $replace = "\'";
            $clean_input = preg_replace($search, $replace, $input);
            return $clean_input;
        }

        function save()
        {
            $this->setServices($this->adjustPunctuation($this->getServices()));
            $GLOBALS['DB']->exec("INSERT INTO stylists (name, services, phone) VALUES ('{$this->getName()}', '{$this->getServices()}', '{$this->getPhone()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists");
            $all_stylists = array();
            foreach ($returned_stylists as $stylist){
                $name = $stylist['name'];
                $services = $stylist['services'];
                $phone = $stylist['phone'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $services, $phone, $id);
                array_push($all_stylists, $new_stylist);
            }
            return $all_stylists;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        static function find($id)
        {
            $all_stylists = Stylist::getAll();
            $found_stylist = null;
            foreach($all_stylists as $stylist){
                $stylist_id = $stylist->getId();
                if ($stylist_id == $id) {
                    $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
        }

        function update($new_name, $new_services, $new_phone)
        {
            $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}', services = '{$new_services}', phone = '{$new_phone}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setServices($new_services);
            $this->setPhone($new_phone);
        }

        function getClients()
        {
            $stylist_id = $this->getId();
            $all_clients = Client::getAll();
            $matching_clients = array();
            foreach($all_clients as $client){
                $client_stylist_id = $client->getStylistId();
                if($stylist_id == $client_stylist_id) {
                    array_push($matching_clients, $client);
                }
            }
            return $matching_clients;
        }

    }




 ?>
