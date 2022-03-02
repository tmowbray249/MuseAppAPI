<?php

abstract class response {

    protected $data;

    public function __construct(){
        $this->headers();
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    protected function headers() {}

}