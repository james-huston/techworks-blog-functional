<?php

define('NO_AUTH', true);
require_once('includes/header.inc.php');

$message = [];

if (isset($_POST['submitform'])) {
    $message = handleFormSubmit($_POST, $DB_CONN, $_SESSION);

    if (isset($message['success'])) {
        header('Location: index.php');
        exit();
    }
}

print TBU_getmessage($message);

?>

<div class="well col-xs-12 col-sm-4 col-sm-offset-4">
    <form method="post" action="login.php" class="form-horizontal" role="form" id="form-login">
        <div class="form-group col-xs-12">
            <input type="text" class="form-control input-lg" placeholder="Username" id="input_username" name="username" />
        </div>
        <div class="form-group col-xs-12">
            <input type="password" class="form-control input-lg" placeholder="Password" id="input_password" name="password" />
        </div>
        <div class="form-group col-xs-12">
            <input type="submit" class="btn btn-primary center-block" id="input_submit" name="submitform" />
        </div>
    </form>
</div>

<?php

require_once('includes/footer.inc.php');

/**
 * Deal with our login form being submitted
 * @param Array $dataArray
 * @param mysqli $db
 */
function handleFormSubmit($dataArray, $db) {
    if (!isset($dataArray['username']) || !isset($dataArray['password'])) {
        return ['error' => 'Please check all required variables'];
    }

    $dbPassword = hash('sha256', $dataArray['password']);

    $results = $db->query("
        SELECT
            `id`
        FROM
            `users`
        WHERE
            `username` = '" . $db->real_escape_string($dataArray['username']) . "'
            AND `password` = '" . $db->real_escape_string($dbPassword) . "'
    ");

    if ($results->num_rows !== 1) {
        return ['error' => 'Invalid username/password'];
    }

    $userRow = $results->fetch_object();

    $_SESSION['userid'] = $userRow->id;

    return ['success' => 'Login Successful'];
}
