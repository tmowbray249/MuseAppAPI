<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;

class APIAuthenticateController extends Controller {

    # todo should this check that the user is an admin user if the request comes from the admin frontend?

    protected function setGateway() {
        $this->gateway = new UserGateway();
    }

    protected function processRequest() {
        $data = [];

        if ($this->getRequest()->getRequestMethod() === "POST") {
            $token = $this->getRequest()->getParameter("token");
            $username = $this->getRequest()->getParameter("username");
            $password = $this->getRequest()->getParameter("password");

            if (!is_null($token)) {
                $key = SECRET_KEY;
                try {
                    $decoded = JWT::decode($token, new Key($key, 'HS256'));
                    if (isset($decoded->iss)) {
                        $issuer = parse_url($decoded->iss, PHP_URL_PATH);
                        if ($issuer === BASEPATH) {
                            $data = ['token' => $token, 'username' => $decoded->sub];
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
                if (!is_null($username) && !is_null($password)) {

                    $this->getGateway()->findPassword($username);

                    if (count($this->getGateway()->getResult()) == 1) {
                        $password_hash = $this->getGateway()->getResult()[0]['password'];

                        if (password_verify($password, $password_hash)) {
                            $key = SECRET_KEY;

                            $payload = [
                                'sub' => $username,
                                'user_id' => $this->getGateway()->getResult()[0]['user_id'],
                                'iss' => 'http://unn-w17020085.newnumyspace.co.uk/museapp/MuseAppAPI/',  # todo this needs updating to the correct issuer url
                                'aud' => '<\set audience\>',
                                'iat' => time(),
                                'exp' => time() + 259200 // 3 days
                            ];

                            $jwt = JWT::encode($payload, $key, 'HS256');
                            $data = ['token' => $jwt, 'username' => $username];
                        }
                    }
                }

                if (!array_key_exists('token', $data)) {
                    $this->getResponse()->setUnauthorisedResponse("Incorrect username or password");
                }
            }
        } else {
            $this->getResponse()->setMethodNotAllowedResponse("This endpoint only supports POST requests");
        }

        return $data;
    }
}