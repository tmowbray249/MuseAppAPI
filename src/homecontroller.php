<?php

class HomeController extends Controller {

    protected function processRequest() {
        $page = new Homepage("Muse API  ", "Home");
        return $page->generateWebpage();
    }

}