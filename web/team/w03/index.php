<?php include 'library.php'; ?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <form action="response.php" method="POST">
        <label for="name">Name: </label>
        <input type="text" id="name" name="name"> <br>
        <label for="Email">Email: </label>
        <input type="text" id="Email" name="email"> <br>
        
        Major: <br>
        <?php foreach ($list_of_majors as $key => $value) {
                echo "<label><input type='radio' name='major' value='$key'>$value</label><br>";
        } ?>
​
        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" rows="3"></textarea><br>
​
        Continents you have visited: <br>
        <?php foreach ($list_of_continents as $key => $continent) { ?>
             <label><input type="checkbox" name="continents[]" value="<?=$key?>"><?=$continent?></label><br>
        <?php } ?>
​
        <input type="submit" value="Submit">
    </form>
  </body>
</html>