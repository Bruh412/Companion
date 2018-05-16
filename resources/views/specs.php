<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>

<body>
    <form method="post" action="<?php echo url('/register') ?>">
          <?php echo csrf_field(); ?> 
        <input type="text" name="userType"><br>
        <input type="checkbox" name="specs[]" value="Mental Health Counselor">Mental Health Counselor<br>
        <input type="checkbox" name="specs[]" value="LGBTQ Counselor">LGBTQ Counselor<br>
        <input type="checkbox" name="specs[]" value="Grief Counselor">Grief Counselor<br>
        <input type="checkbox" name="specs[]" value="Geriatric Counselor">Geriatric Counselor<br>
        <input type="checkbox" name="specs[]" value="Child Counselor">Child Counselor<br>
        <input type="checkbox" name="specs[]" value="Career and Vocational">Career and Vocational<br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
 </html>