<?php

/**
 * Request Validation
 *
 * @package Shin
 */

namespace Zippy_Booking\Src\App\Models;

defined('ABSPATH') or die();

use DateTime;

class Zippy_Request_Validation
{
  public static function validate_request($required_fields, $request){
    /* Validate main required fields */
    foreach ($required_fields as $field => $rules) {
        if ($rules['required'] && (!isset($request[$field]) || empty($request[$field]))) {
            return "$field is required";
        }

        if ($rules["data_type"] == "range") {
            if (!in_array($request[$field], $rules['allowed_values'], true)) {
                return "$field must be one of: " . implode(", ", $rules['allowed_values']);
            }
        }


        // time
        if ($rules["data_type"] == "time" && !empty($request[$field])) {
            $datetime = DateTime::createFromFormat('H:i:s', $request[$field]);
            if (!$datetime || $datetime->format('H:i:s') !== $request[$field]) {
                return "$field must be a valid time in the format H:i:s.";
            }
        }


        // datetime
        if ($rules["data_type"] == "time" && !empty($request[$field])) {
            $datetime = DateTime::createFromFormat('d-m-Y H:i:s', $request[$field]);
            if (!$datetime || $datetime->format('d-m-Y H:i:s') !== $request[$field]) {
                return "$field must be a valid datetime in the format d-m-Y H:i:s.";
            }
        }


        // date
        if ($rules["data_type"] == "date" && !empty($request[$field])) {
          $datetime = DateTime::createFromFormat('d-m-Y', $request[$field]);
          if (!$datetime || $datetime->format('d-m-Y') !== $request[$field]) {
              return "$field must be a valid date in the format d-m-Y.";
          }
      }


        // String
        if ($rules["data_type"] == "string" && !empty($request[$field])) {
            if (!is_string($request[$field])) {
                return "$field must be string";
            }
        }


        // Number
        if ($rules["data_type"] == "number" && !empty($request[$field])) {
            if (!is_numeric($request[$field])) {
                return "$field must be number";
            }
        }


        // Array
        if ($rules["data_type"] == "array" && !empty($request[$field])) {
            if (!is_array($request[$field])) {
                return "$field must be array";
            }
        }


        // Email
        if ($rules["data_type"] == "email" && !empty($request[$field])) {
            if (!is_email($request[$field])) {
                return "$field must be email";
            }
        }
    }
  }
}
