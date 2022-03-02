<?php

function errorHandler($errNo, $errStr, $errFile, $errLine) {

    if (($errNo != 2 && $errNo != 8) || DEV_MODE) {
        throw new Exception("Error Detected: [$errNo] $errStr file: $errFile line: $errLine");
    }

}
