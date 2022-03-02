<?php

class ErrorController extends Controller {

    protected function processRequest() {
        if (substr($this->getRequest()->getPath(), 0, 3) === "api") {
            $this->getResponse()->set404Response();

            return [];
        } else {
            $this->setPage(new HTML404Page("404", "404 - Page not found"));
            return $this->page->generateWebpage();
        }
    }
}