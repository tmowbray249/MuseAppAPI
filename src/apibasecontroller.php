<?php

class APIBaseController extends Controller {

    protected function processRequest() {

        $data = [];

        if ($this->getRequest()->getRequestMethod() === "GET") {

            if (empty($_GET)) {
                $url = 'http://example.com/' . BASEPATH . "api";
                $data = [
                    'name' => "<\Names>",
                    'id' => "<\Names>",
                    'description' => "This API <\Does something>",
                    'available_endpoints' => [
                        $url,
                        "<http://example.com"
                    ]
                ];
            } else {
                $this->getResponse()->setUnprocessableEntityResponse();
            }

        } else {
            $this->getResponse()->setMethodNotAllowedResponse("This endpoint only supports GET requests");
        }
        return $data;
    }

}