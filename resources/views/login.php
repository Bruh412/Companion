<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>

<body>
    <h1>Post here!</h1>
    <form method="post" action="<?php echo url('/login') ?>">
         <?php echo csrf_field(); ?>
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit" name="submit">Submit</button>
    </form>

    <a href="/groupUser/S0001/Sad">Queue</a><br>
    <a href="/checkQueue/S0003">check</a>
</body>
 </html>