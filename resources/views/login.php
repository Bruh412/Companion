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
</body>
 </html>