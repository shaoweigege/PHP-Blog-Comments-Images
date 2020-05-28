<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PDO Installation step 1</title>
    <link rel="stylesheet" type="text/css" href="css/install.css">
</head>
<body>

    <h2>Blog Installation Step 1</h2>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <fieldset>
        <br>
        <label>Name of your blog</label><br>
        <input name="blog_title" value="PHP Blog">
        <br><br>
        <label>Posts per page</label><br>
        <input name="perpage" type="number" value="8">
        <br><br>
        <label>Timezone</label><br>
        <input name="timezone" value="America/New_York">
        <br><br>
        <label>Setlocale for time</label><br>
        <input name="locale" value="english">
        <br><br><br>
        <label>Select Database</label><br>
        <select name="driver">
            <option value="sqlite" selected>SQLite</option>
            <option value="mysql">MySQL</option>          
        </select>
        <input type="hidden" name="step" value="1">
        <br><br><br>
        <input type="submit" value="SUBMIT">
        </fieldset>
    </form>

</body>
</html>
