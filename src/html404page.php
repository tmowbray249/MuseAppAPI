<?php

class HTML404Page extends Webpage {

    public function __construct($title, $heading) {
        parent::__construct($title, $heading);
        $this->writeErrorContent();
    }

    private function writeErrorContent () {
        $this->addHeading2("The page you requested was not found.");
    }

}