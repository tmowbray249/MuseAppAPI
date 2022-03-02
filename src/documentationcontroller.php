<?php

class DocumentationController extends Controller
{

    protected function processRequest()
    {
        $page = new DocumentationPage("Documentation", "Documentation");

        $baseData = $this->prepareBaseEndpoint();
        $page->writeEndpoint($baseData);

        return $page->generateWebpage();
    }

    private function prepareBaseEndpoint(){
        $url = "http://www.example.com";
        return [
            'name' => "Endpoint Name",
            'endpointInfo' => [
                'url' => $url,
                'request_methods' => [
                    "<\available request methods>"
                ],
                'parameters' => [
                    "<\parameters here or 'none'>"
                ],
                'content' => [
                    'description' => "This endpoint returns meta information regarding the API.",
                    'json_description' => "A json object is returned that includes the following information: <b>status code</b>,
                                           <b>status text</b>, <b>row count</b>, <b>API authors name</b>, <b>API authors ID</b>, <b>a description of the API</b> and 
                                           <b>a list of the available endpoints</b>.",
                ],
                'http_codes' => [
                    '200: Ok',
                    '405: Method Not Allowed',
                    '422: Unprocessable Entity',
                    '500: Internal Server Error',
                ],
                'examples' => [
                    '200: Ok' => [
                        'url' => $url,
                        'response' => [
                            "statusCode" => 200,
                            "statusText" => "Ok",
                            "count" => 3,
                            "data" => [
                                "name" => "<\authors name>",
                                "id" => "<\authors id>",
                                "description" => "This API <\does something>",
                                "available_endpoints" => [
                                    "http://example.com",
                                ],
                            ]
                        ],
                        'description' => "The request was valid and a response has been returned."
                    ],
                    '405: Method Not Allowed' => [
                        'url' => $url,
                        'request_body' => [
                            'some_param' => "some_value",
                        ],
                        'response' => [
                            "statusCode" => 405,
                            "statusText" => "Method not allowed",
                            "message" => "This endpoint only supports GET requests."
                        ],
                        'description' => "A POST request was used instead of the expected GET request."
                    ],
                    '422: Unprocessable Entity' => [
                        'url' => $url . "?some_query=some_value",
                        'response' => [
                            "statusCode" => 422,
                            "statusText" => "Unprocessable Entity",
                            "message" => "A parameter you provided is not supported by this endpoint."
                        ],
                        'description' => "An unexpected query parameter was supplied."
                    ],
                    '500: Internal Server Error' => [
                        'url' => $url,
                        'response' => [
                            "statusCode" => "500",
                            "statusText" => "Internal Server Error",
                            "message" => "Something went wrong on our end. Please try again later."
                        ],
                        'description' => "Something went wrong internally."
                    ]
                ]
            ]
        ];
    }

}