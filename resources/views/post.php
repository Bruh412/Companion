<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>

<body>
    <h1>Post here!</h1>
    <form method="post" action="<?php echo url('/posts/save') ?>">
         <?php echo csrf_field(); ?>
        <textarea type="text" name="post"></textarea><br>
        Feeling 
        <select name="feeling">
            <option value="Sad">Sad</option>
            <option value="Sorry">Sorry</option>
            <option value="Hurt">Hurt</option>
            <option value="Lost">Lost</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
 </html>