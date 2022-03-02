<?php

function HTMLExceptionHandler($e) {
    echo "<p>internal server error! (Status 500)</p>";
    if (DEV_MODE) {
        echo "Message: " . $e->getMessage();
        echo "<br>File: " . $e->getFile();
        echo "<br>Line: " . $e->getLine();
        echo "</p>";
    }
}