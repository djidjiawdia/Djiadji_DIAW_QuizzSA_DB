<?php

    function validateLogin($login){
        if(empty($login)) return json_encode(['type' => 'errorLog', 'message' => 'Login ne doit pas être vide']);
        if(!checkIfOnlyLetters($login)) return json_encode(['type' => 'errorLog', 'message' => 'Login doit contenir que des lettres']);
        return true;
    }

    function validatePassword($password){
        if(empty(($password))) return json_encode(['type' => 'errorLog', 'message' => 'Mot de passe ne doit pas être vide']);
        if(!minLength($password, 6)) return json_encode(['type' => 'errorLog', 'message' => 'Mot de passe doit contenir au moins 6 caractères']);
        if(!maxLength($password, 30)) return json_encode(['type' => 'errorLog', 'message' => 'Mot de passe doit être plus court 30 caractères']);
        if(!containsCharacters($password, 1)) return json_encode(['type' => 'errorLog', 'message' => 'Doit contenir au moins une lettre']);
        if(!containsCharacters($password, 2)) return json_encode(['type' => 'errorLog', 'message' => 'Doit contenir au moins une lettre']);
        return true;
    }

    function confirmPassword($password, $confirm){
        if($password === $confirm) return true;
    }

    function minLength($value, $size){
        if(strlen($value) >= $size) return true;
    }

    function maxLength($value, $size){
        if(strlen($value) < $size) return true;
    }

    function checkIfOnlyLetters($value){
        if(preg_match('/^[a-zA-Z]+$/', $value)) return true;
    }

    function containsCharacters($value, $code){
        $regEx = '';
        switch($code){
            case 1 :
                // letter
                $regEx = '/(?=.*[a-zA-Z])/';
                return matchWithRegEx($value, $regEx);
            case 2 :
                // letter & number
                $regEx = '/(?=.*\d)(?=.*[a-zA-Z])/';
                return matchWithRegEx($value, $regEx);
            case 3 :
                // lowercase, uppercase & number
                $regEx = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/';
                return matchWithRegEx($value, $regEx);
            case 4 :
                // lowercase, uppercase, number & special char
                $regEx = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/';
                return matchWithRegEx($value, $regEx);
            default :
                return false;
        }
    }

    function matchWithRegex($regEx, $value){
        if(preg_match($regEx, $value)) return true;
    }