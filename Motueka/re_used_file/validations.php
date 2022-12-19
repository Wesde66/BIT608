<?php
function password_validation($password){
    $passwordCh = $password;
    $uppercase = preg_match('@[A-Z]@', $passwordCh);
    $lowercase = preg_match('@[a-z]]@', $passwordCh);
    $number = preg_match('@[0-9]@', $passwordCh);
    $specialChars = preg_match('@[^\w]@', $passwordCh);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($passwordCh)< 8){
        $passwordCh = "";
        $password = $passwordCh;
        return $password;
    }else {
        return $password;
    }

}