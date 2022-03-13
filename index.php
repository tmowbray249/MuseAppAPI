<?php
include "config/config.php";

$request = new request();

if (substr($request->getPath(), 0, 3) === "api") {
    $response = new JSONResponse();
} else {
    set_exception_handler("HTMLExceptionHandler");
    $response = new HTMLResponse();
}

switch ($request->getPath()) {
    case '':
    case 'home':
        #todo load the admin app from here?
        $controller = new HomeController($request, $response);
        break;

    case 'documentation':
        $controller = new DocumentationController($request, $response);
        break;

    case 'api':
        $controller = new APIBaseController($request, $response);
        break;

    case 'api/authenticate':
        $controller = new APIAuthenticateController($request, $response);
        break;

    case 'api/events':
        $controller = new apieventscontroller($request, $response);
        break;

    default:
        $controller = new ErrorController($request, $response);
        break;
}

echo $response->getData();