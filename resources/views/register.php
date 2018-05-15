<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>

<body>
    <h1>Register here!</h1>
    <form method="post" action="<?php echo url('/registerSeeker') ?>">
         <!-- <?php //echo csrf_field(); ?> -->
        <input type="text" name="fname" placeholder="First Name"><br>
        <input type="text" name="lname" placeholder="Last Name"><br>
        <input type="text" name="username" placeholder="Username"><br>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="birthday" placeholder="MM/DD/YYYY"><br>
        <input type="text" name="address" placeholder="address"><br>        
        <select name="gender">
            <option value="female">Female</option>
            <option value="male">Male</option>
        </select><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="password" name="confirm" placeholder="Confirm Password"><br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
 </html>