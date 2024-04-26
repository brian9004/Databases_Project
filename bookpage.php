<!DOCTYPE html>
<html>
<head>
    <title>Button Redirect</title>
</head>
<body>
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Your condition to check
        $condition = true; // Change this to your actual condition

        if ($condition) {
            // Perform any necessary actions or store information
            $information = "Some information you want to pass";

            // Redirect to another page with information as query parameter
            header("Location: nextpage.php?info=" . urlencode($information));
            exit;
        } else {
            // Handle condition not met
            echo "Condition not met";
        }
    }
    ?>

    <form method="post">
        <input type="submit" name="submit" value="Check Condition">
    </form>
</body>
</html>
