[@layout layouts/General]

<form action="/test_csrf" method="POST">
    [@csrf]
    <input type="text" name="username" />
</form>

<?php
if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $origin = $_SERVER['HTTP_ORIGIN'];
}
else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
    $origin = $_SERVER['HTTP_REFERER'];
} else {
    $origin = $_SERVER['REMOTE_ADDR'];
}
?>
Origin: <?= $origin ?>