<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>

<body>
    <h1>DISPLAY POSTS</h1>
     <?php foreach($posts as $post) {?> 
         <h6><?php echo $post['post_content'] ?></h6> 
         <h6><?php dd($post->usersPostFeeling->postFeeling->post_feeling_name) ?></h6> 
     <?php } ?> 
</body>
 </html>