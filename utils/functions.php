<?php
function myVerify(...$args) {
    foreach ($args as $arg) {

        if (isset($arg) && !empty($arg)) {
            return true;
        } else {
            return false;
        }
    }
}

function myEncrypte($param, $type) {
    if ($type == "str") {
        return filter_var($param, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    
    if ($type == "mail") {
        return filter_var($param, FILTER_SANITIZE_EMAIL);
    }
    
    if ($type == "pass") {
        return password_hash($param, PASSWORD_ARGON2ID);
    }
    
    if ($type == "int") {
        return filter_var($param, FILTER_SANITIZE_NUMBER_INT);
    }
}
?>
