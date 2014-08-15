<?php

function TBU_validateform($requiredArray, $formData) {
    $failedArray = [];
    foreach($requiredArray as $required) {
        if (!isset($formData[$required]) || !strlen($formData[$required])) {
            $failedArray[] = $required;
        }
    }

    return $failedArray;
}

function TBU_getmessage($messageArray) {
    if (!is_array($messageArray)) {
        return '';
    }

    if (isset($messageArray['error'])) {
        return '<h3 class="bg-danger tb-message">' . $messageArray['error'] . '</h3>';
    }

    if (isset($messageArray['success'])) {
        return '<h3 class="bg-success tb-message">' . $messageArray['success'] . '</h3>';
    }

    return '';
}

