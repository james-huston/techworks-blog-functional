<?php

require_once('includes/header.inc.php');
require_once('includes/navigation.inc.php');

$message = [];

if (isset($_POST['submituser'])) {
    $message = handlePost($_POST, $DB_CONN);
}

print TBU_getmessage($message);

?>

    <form id="form-post-create" class="form-horizontal" method="post" action="<?=$_SERVER['PHP_SELF']?>" role="form">
        <div class="form-group">
            <label for="input-post-name" class="col-sm-2 control-label">Name *</label>
            <div class="col-sm-10">
                <input class="form-control" id="input-post-name" type="text" name="name" />
            </div>
        </div>
        <div class="form-group">
            <label for="input-post-username" class="col-sm-2 control-label">UserName *</label>
            <div class="col-sm-10">
                <input class="form-control" id="input-post-username" type="text" name="username" />
            </div>
        </div>
        <div class="form-group">
            <label for="input-post-password" class="col-sm-2 control-label">Password *</label>
            <div class="col-sm-10">
                <input class="form-control" id="input-post-password" type="password" name="password" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2 col-xs-12">
                <input type="submit" name="submituser" class="btn btn-primary" value="Create User" />
            </div>
        </div>
    </form>

<?php

require_once('includes/footer.inc.php');

function handlePost($dataArray, $db) {
    $requiredArray = [
        'username',
        'name',
        'password'
    ];

    $missingArray = TBU_validateForm($requiredArray, $dataArray);

    if (count($missingArray)) {
        return ["error" => "Please check all required fields!"];
    }

    $query = $db->prepare("
        INSERT INTO `users`
            (`name`, `username`, `password`)
        VALUES
            (?, ?, ?)
    ");

    if (!$query) {
        return ["error" => "Failed to create insert query: " . $db->error];
    }

    $query->bind_param(
        'sss',
        $dataArray['name'],
        $dataArray['username'],
        hash('sha256', $dataArray['password'])
    );

    if ($query->execute()) {
        $query->close();
        return ["success" => "User created!"];
    }

    $query->close();
    return ["error" => "Unable to save user: " . $db->error];

}
