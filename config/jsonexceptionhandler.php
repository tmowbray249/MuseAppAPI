<?php

function JSONExceptionHandler($e)
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $output['statusCode'] = "500";
    $output['statusText'] = "Internal Server Error";
    $output['message'] = "Something went wrong on our end. Please try again later.";

    if (DEV_MODE) {
        $output['Message'] = $e->getMessage();
        $output['File'] = $e->getFile();
        $output['Line'] = $e->getLine();
    }

    echo json_encode($output);
}
