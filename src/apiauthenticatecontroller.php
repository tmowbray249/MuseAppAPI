<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

class APIAuthenticateController extends Controller {

    protected function setGateway() {
        $this->gateway = new UserGateway();
    }

    protected function processRequest() {
        $data = [];

        if ($this->getRequest()->getRequestMethod() === "POST") {
            $token = $this->getRequest()->getParameter("token");
            $email = $this->getRequest()->getParameter("email");
            $password = $this->getRequest()->getParameter("password");

            if (!is_null($token)) {
                $key = SECRET_KEY;
                try {
                    $decoded = JWT::decode($token, new Key($key, 'HS256'));
                    if (isset($decoded->iss)) {
                        $issuer = parse_url($decoded->iss, PHP_URL_PATH);
                        if ($issuer === BASEPATH) {
                            $data = ['token' => $token];
                        }
                    } else {
                        $this->getResponse()->setUnauthorisedResponse("You do not have permission to access this endpoint");
                    }
                } catch (ExpiredException $e) {
                    $this->getResponse()->setUnauthorisedResponse("Expired Token");
                } catch (Exception $e) {
                    $this->getResponse()->setUnauthorisedResponse("You do not have permission to access this endpoint");
                }

            } else {
                if (!is_null($email) && !is_null($password)) {

                    $this->getGateway()->findPassword($email);

                    if (count($this->getGateway()->getResult()) == 1) {
                        $password_hash = $this->getGateway()->getResult()[0]['password'];

                        if (password_verify($password, $password_hash)) {
                            $key = SECRET_KEY;

                            $payload = [
                                'sub' => $email,
                                'user_id' => $this->getGateway()->getResult()[0]['id'],
                                'iss' => '<\Issuer url>',
                                'aud' => '<\audience identifier>',
                                'iat' => time(),
                                'exp' => time() + 259200 // 3 days
                            ];

                            $jwt = JWT::encode($payload, $key, 'HS256');
                            $data = ['token' => $jwt];
                        }
                    }
                }

                if (!array_key_exists('token', $data)) {
                    $this->getResponse()->setUnauthorisedResponse("Incorrect email or password");
                }
            }
        } else {
            $this->getResponse()->setMethodNotAllowedResponse("This endpoint only supports POST requests");
        }

        return $data;
    }
}