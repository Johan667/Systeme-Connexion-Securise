<?php

// Class ensemble d'etat (propriété) et de comportement (méthodes)

    class MyError
    {
        private $_code;
        private $_message;
        private $_time;

        public function __construct($code = 0, $message = '')
        {
            $this->_code = $code;
            $this->_message = $message;
            $this->_time = new DateTime('NOW', new DateTimeZone('Europe/Paris'));
        }

        public function setError($code = 0, $message = '')
        {
            $this->_code = $code;
            $this->_message = $message;
            $this->_time = new DateTime('NOW', new DateTimeZone('Europe/Paris'));
        }

        public function __toString()
        {
            return ($this->_code != 0) ? '['.$this->_time->format('Y-m-d H:i:s').'] Error'.$this->_code.':'.$this->_message : '';
        }
    }
