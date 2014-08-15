<?php

require_once('includes/header.inc.php');
require_once('includes/navigation.inc.php');

$message = [];

if (isset($_POST['submitpost'])) {
    $message = handlePost($_POST, $DB_CONN);
}

print TBU_getmessage($message);

?>

<form id="form-post-create" class="form-horizontal" method="post" action="<?=$_SERVER['PHP_SELF']?>" role="form">
    <div class="form-group">
        <label for="input-post-name" class="col-sm-2 col-xs-12 control-label">Name</label>
        <div class="col-sm-10 col-xs-12">
            <input class="form-control" id="input-post-name" type="text" name="name" />
        </div>
    </div>
    <div class="form-group">
        <label for="input-post-content" class="col-sm-2  col-xs-12 control-label">Content</label>
        <div class="col-sm-10 col-xs-12">
            <textarea name="content" id="input-post-content" class="form-control" rows="20"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2 col-xs-12">
            <input type="submit" name="submitpost" class="btn btn-primary" value="Create Post" />
        </div>
    </div>
</form>

<?php

require_once('includes/footer.inc.php');

function handlePost($dataArray, $db) {
    $requiredArray = [
        'name',
        'content'
    ];

    $missingArray = TBU_validateForm($requiredArray, $dataArray);

    if (count($missingArray)) {
        return ["error" => "Please check all required fields!"];
    }

    $query = $db->prepare("
        INSERT INTO posts
            (`name`, `content`, `date_created`, `user_id`)
        VALUES
            (?, ?, NOW(), ?)
    ");

    if (!$query) {
        return ["error" => "Failed to create insert query: " . $db->error];
    }

    $query->bind_param(
        'ssi',
        $dataArray['name'],
        $dataArray['content'],
        $_SESSION['userid']
    );

    if ($query->execute()) {
        $query->close();
        return ["success" => "Post created!"];
    }

    $query->close();
    return ["error" => "Unable to save post: " . $db->error];
}
