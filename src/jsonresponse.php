<?php

class JSONResponse extends response {

    private $statusCode;
    private $statusText;
    private $message;

    public function headers() { //override empty method in parent class
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    }

    public function getData() {
        if (is_null($this->data)) {
            $this->data = [];
        }

        if (is_null($this->message)) {
            if (count($this->data) > 0) {
                $this->setOkResponse();
            } else {
                $this->setNoContentResponse();
            }
        }

        $response['statusCode'] = $this->statusCode;
        $response['statusText'] = $this->statusText;
        if (!is_null($this->message)) {
            $response['message'] = $this->message;
        } else {
            $response['count'] = count($this->data);
            $response['data'] = $this->data;
        }

        return json_encode($response);
    }

    public function setStatusCode($code) {
        $this->statusCode = $code;
    }

    public function setStatusText($text) {
        $this->statusText = $text;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setOkResponse($message="") {
        $this->setStatusCode(200);
        $this->setStatusText("Ok");
        if ($message !== "") {
            $this->setMessage($message);
        }
    }

    public function setNoContentResponse() {
        $this->setStatusCode(204);
        $this->setStatusText("No content");
        $this->setMessage("No results were found for the value(s) provided");
    }

    public function setUnauthorisedResponse($message) {
        $this->setStatusCode(401);
        $this->setStatusText("Unauthorised");
        $this->setMessage($message);
    }

    public function setMethodNotAllowedResponse($message) {
        $this->setStatusCode(405);
        $this->setStatusText("Method Not Allowed");
        $this->setMessage($message);
    }

    public function setUnprocessableEntityResponse() {
        $this->setStatusCode(422);
        $this->setStatusText("Unprocessable Entity");
        $this->setMessage("A parameter you provided is not supported by this endpoint");
    }

    public function set404Response() {
        $this->setStatusCode(404);
        $this->setStatusText("Not Found");
        $this->setMessage("The endpoint you searched for does not exist");
    }
}