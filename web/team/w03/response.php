<?php include 'library.php'; ?>
<?php
    // Filter all incoming data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $major = filter_input(INPUT_POST, 'major', FILTER_SANITIZE_STRING);
    // Check if data is sent and update is value else leave empty
    $major = (!empty($major)) ? $list_of_majors[$major] : '';
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);
    // Filter an Array
    $continents = filter_input(INPUT_POST, 'continents', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
?>
<html>
  <head>
    <title>PHP Test Response</title>
  </head>
    <body>
        <h1>POST Results</h1>
        <?php
            echo 'Your name is: ' . $name . '<br>';
            echo "Your email is: <a href='mailto:$email'>$email</a><br>";
            echo 'Your major is: ' . $major . '<br>';
            echo 'Comments: ' .$comments . '<br>';
        ?>
        You have been to the following places:<br>
        <ul>
        <?php foreach ($continents as $key) {
             echo "<li>$list_of_continents[$key]</li>";
        } ?>
        </ul>
    </body>
</html>