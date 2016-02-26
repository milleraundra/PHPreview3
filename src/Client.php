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


    }




?>
