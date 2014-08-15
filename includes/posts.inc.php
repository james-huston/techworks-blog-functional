<?php

$posts = [];

$posts['results'] = $DB_CONN->query("
SELECT
    p.name as Title,
    p.content as Content,
    u.name as Author,
    p.date_created as DateCreated
FROM
    `posts` p
    INNER JOIN `users` u ON (p.user_id = u.id)
");


if (!$posts['results']) {
    print "No posts available";
    return;
}

foreach($posts['results'] as $currentPost) {
    ?>
    <div class="tb-post col-xs-12">
        <h2 class="tb-post-heading">
          <?=$currentPost['Title'] ?>
        </h2>
        <div class="tb-post-author col-xs-12">
            <?=$currentPost['Author'] . " - " . $currentPost['DateCreated']?>
        </div>
        <div class="tb-post-content col-xs-12">
          <?=$currentPost['Content'] ?>
        </div>
    </div>
    <?php
}

$posts['results']->close();
