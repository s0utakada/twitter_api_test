<?php

    require_once('config.php');
    require_once('TwistOAuth.php');
    
    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    
    @session_start();

    if (!isset($_SESSION['logined'])) {
        $url = SITE_URL.'callback.php';
        header("Location: $url");
        header('Content-Type: text/plain; charset=utf-8');
        exit("Redirecting to $url ...");
    }

    $code = 200;
    
    date_default_timezone_set(TIME_ZONE);

    $text = filter_input(INPUT_POST, 'text');
    
    if ($text !== null) {

        try {

            $_SESSION['to']->post('statuses/update', array('status' => $text));
            $message = array('green', 'Successfully tweeted.');
            $text = '';

        } catch (TwistException $e) {

            $message = array('red', $e->getMessage());
            $code = $e->getCode() > 0 ? $e->getCode() : 500;

        }

    }

    try {

        $to = new TwistOAuth(CONSUMER_KEY, CONSUMER_SECRET, API_TOKEN, API_TOKEN_SECRET);
        $statuses = $to->get('statuses/home_timeline', array('count' => TIME_LINE_COUNT));

    } catch (TwistException $e) {

        $error = $e->getMessage();
        $code = $e->getCode() > 0 ? $e->getCode() : 500;

    }

    header('Content-Type: text/html; charset=utf-8', true, $code);
    
?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>HOME</title>
</head>
<body>

<h1>POST</h1>
<form action="" method="post">
    <input type="text" name="text" value="<?=h($text)?>">
    <input type="submit" value="Tweet">
</form>
<?php if (isset($message)): ?>
    <p style="color:<?=$message[0]?>;"><?=h($message[1])?></p>
<?php endif; ?>

<h1>TimeLine</h1>
<?php if (isset($error)): ?>
    <p style="color:red;"><?=h($error)?></p>
<?php endif; ?>
<?php if (!empty($statuses)): ?>
    <?php foreach ($statuses as $status): ?>
        <p>
            user_id: <?=$status->user->id_str?><br>
            screen_name: @<?=$status->user->screen_name?><br>
            name: <?=h($status->user->name)?><br>
            text: <?=$status->text?><br>
            time: <?=strtotime($status->created_at)?><br>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>