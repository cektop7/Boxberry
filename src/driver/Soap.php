<?php
/**
 * @Description: Создано в России 
 * @User: aleksey.nikulin
 * @Date: 27.06.2016
 * @Time: 21:29
 * @Email: masterweb@e1.ru
 */

namespace BoxberryApi\Soap;

    class Soap
    {
        /**
         * @var string
         */
        public $method = '';

        /**
         * @var array
         */
        public $args = [];

        /**
         * @var array
         */
        public $error = [];

        /**
         * @var array
         */
        public $soap = [];

        /**
         * @param string $method
         * @param array $args
         */
        function __construct($method = '', $args = [])
        {
            $this->method = $method;
            $this->args = $args;
        }

        /**
         * @param \stdClass $data
         * @return mixed
         */
        function toArray(\stdClass $data)
        {
            return json_decode(json_encode($data), 1);
        }

        /**
         * @return mixed
         */
        function Request()
        {
            if ($client = $this->connect()) {
                try {
                    $method = $this->method;
                    return $this->toArray($client->$method($this->args));
                } catch (\SoapFault $e) {
                    $this->error[] = $e->getMessage();
                }
            }
        }

        /**
         * @return \SoapClient
         */
        private function connect()
        {
            try {
                return new \SoapClient(HOST.$this->setWsdlDocument());
            } catch (\SoapFault $e) {
                $this->error[] = $e->getMessage();
            }
        }

        /**
         * @return int|string
         */
        private function setWsdlDocument()
        {
            if (defined("SOAP")) {
                $this->soap = json_decode(SOAP, 1);
                foreach ($this->soap as $k => $a) {
                    if (in_array($this->method, $a)) {
                        return $k;
                    }
                }
                return (string)array_pop(array_keys($this->soap));
            }
        }
    }
