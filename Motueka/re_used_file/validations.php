<?php
function password_validation($password){
    $passwordCh = $password;
    $uppercase = preg_match('@[A-Z]@', $passwordCh);
    $lowercase = preg_match('@[a-z]]@', $passwordCh);
    $number = preg_match('@[0-9]@', $passwordCh);
    $specialChars = preg_match('@[^\w]@', $passwordCh);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($passwordCh)< 8){

        return $password;
    }else {
        $passwordCh = "";
        $password = $passwordCh;
        return $password;
    }

}

function mobile_validation ($mobile){
    $m1 = preg_match('/^[0-9]{10}+$/', $mobile);
    $m2 = preg_match('/^[0-9]{11}+$/', $mobile);
    if ($m1 || $m2){

        return $mobile;
    }else{
        $mobile = "";
        return $mobile;
    }
}

function name_validation ($name){
    if (!preg_match('/[a-zA-Z\s]/', $name)){
        $name = "";
        return $name;
    }else{

        return $name;
    }


}