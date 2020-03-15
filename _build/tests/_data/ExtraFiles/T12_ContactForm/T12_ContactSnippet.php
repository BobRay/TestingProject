<?php

if (isset($_POST['submit_button']) && $_POST['submit_button'] === "submitted") {
    /* Handle submitted form */
    $errors = array(
        'user_name' => 'Name is required',
        'user_email' => 'Email is required',
        'user_msg' => 'Message is required',
    );

    foreach ($errors as $key => $errorMessage) {

        if (empty($_POST[$key])) {
            $fields = array_merge($_POST, array('error_message' =>
                '<p style="color:red">' . $errorMessage . '</p>'));

            return $modx->getChunk('ContactChunk', $fields);
        }
    }

    return "<p>Thank you, we'll respond as soon as possible</p>";


} else {
    /* Display Empty Form */
    return $modx->getChunk('ContactChunk');
}