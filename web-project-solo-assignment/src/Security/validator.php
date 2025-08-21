<?php

namespace P2718293\SoloWebDev2025\Security;


class Validator {


    public static function validateLogin(array $data): array
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors[] = "Email is required.";
        }
        if (empty($data['password'])) {
            $errors[] = "Password is required.";
        }
        return $errors;
    }

    public static function validateInterest(array $data) : array {
        $errors = [];

        if(empty($data['programmeId']) || !is_numeric($data['programmeId'])) {
            $errors[] = "Invalid or missing programme.";
        }

        if(empty($data['moduleId']) || !is_numeric($data['moduleId'])) {
            $errors[] = "you must select at least once module.";
        }
        if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "A valid email is required.";
        }
        return $errors;
    }
}

