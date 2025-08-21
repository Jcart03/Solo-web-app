<?php

namespace P2718293\SoloWebDev2025\Security;

/**
 * Sanitiser
 *
 * Centralised input validation and sanitisation utility class.
 * Creates type-safe, clean input from user submitted-data
 */

 class Sanitiser {
    /**
     * Validates and returns a clean email, or null if invalid.
     * @param string $email
     * @return string/null $clean_email
     */
    public static function email(string $email): ?string {
        $email = trim($email);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ?: null;
    }

    /**
     * Sanitises a general string input (trims and strips tags)
     *
     * @param string $input
     *
     * @return string $clean_input
     */
    public static function string(string $input): string {
        return trim(strip_tags($input));
    }
    /**
     * Validates an integer and returns it or null if invalid
     */
    public static function int($input): ?int {
        return filter_var($input, FILTER_VALIDATE_INT) !== false ? (int)$input : null;
    }
    /**
     * Validates a string against a custom regex, currently not using however might prove useful in future ittrs
     * @param string $input
     * @param string $pattern - regex pattern
     *
     * @return string/null - string matched to regex filtered string or null if no match
     */
    public static function regex(string $input, string $pattern): ?string {
        return preg_match($pattern, $input) ? $input : null;
    }
    /**
     * Filters an array to only contain the allowed keys.
     *
     * @param array $data - data from a form e.g. (POST etc)
     * @param array $allowedKeys - allowed set of entries from a form e.g. ('login', 'email')
     * @return array $filtered - malicious fields removed
     */
    public static function whitelist(array $data, array $allowedKeys): array {
        return array_intersect_key($data, array_flip($allowedKeys));
    }
    /**
     * A modified itteration of my original variation which is type smart, this requires a class variable to be defined in controllers
     * that dictates what type of data is where.
     * @param array $data
     * @param array $expectedKeys - the set of types expected
     * @return array $fully sanitised form
     */
    public static function sanitiseForm(array $data, array $expectedFields): array
    {
        $sanitised = [];

        foreach($expectedFields as $key => $type) {
            if (!isset($data[$key])) {
                continue;
            }

            $value = $data[$key];
            switch ($type) {
                case 'email':
                    $sanitised[$key] = self::email($value);
                    break;
                case 'int':
                    $sanitised[$key] = self::int($value);
                    break;
                case 'string':
                    $sanitised[$key] = self::string($value);
                    break;
                default:
                    $sanitised[$key] = $value; //fallback - nothing happens
            }
        }
        return $sanitised;
    }
 }






