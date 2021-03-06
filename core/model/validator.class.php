<?php

class Validator {

    /**
     * Returns true if valid, false if not
     * Validates USA phone numbers.
     * May not work with some international numbers.
     * @param string $phone
     * @return bool
     */
    public function validatePhone($phone) {
        $pattern='~^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*' .
        '([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)' .
        '|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*' .
        '(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]' .
        '{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*' .
        '(?:#|x\.?|ext\.?|extension)\s*(\d+))?$~';

        return (bool) preg_match($pattern, $phone);
    }

    /**
     * Returns true if valid, false if not
     * @param string $name
     * @return bool
     */
    public function validateUsername($name) {
        return (bool) (strlen($name) < 25) &&
            (strlen($name) >= 3);
    }

    /**
     * Returns true if valid, false if not
     * @param string $email
     * @return bool
     */
    public function validateEmail($email) {

      $result =  preg_match('/^(?!(?:(?:\x22?\x5C[\x00-' .
      '\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!' .
      '(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?' .
      '[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27' .
      '\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22' .
      '(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-' .
      '\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:' .
      '(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F' .
      '\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F' .
      '\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))' .
      '*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)' .
      '?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:' .
      '(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-' .
      '[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}' .
      '(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]])' .
      '{7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::' .
      '(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:' .
      '(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)' .
      '|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::' .
      '[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::' .
      '[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2' .
      '[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))' .
      '(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]' .
      '{2})|(?:[1-9]?[0-9]))){3}))]))$/iD', $email);

      /* Alternate test patterns -- faster, but less accurate */
      // $result =  preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email);

      // $result = preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $email);

        return (bool) $result;

    }

}