<?php

$name = $class = $minutes = $reason = $errorMsg = $successMsg = "";

include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $class = $_POST["class"];
    $minutes = $_POST["minutes"];
    $reason = $_POST["reason"];

    do {
        if (empty($name) || empty($class) || empty($reason) ) {
            $errorMsg = "Alle velden zijn verplicht!";
            break;
        }

        if((int)$minutes < 0 || $minutes == "") {
            $errorMsg = "Voer alstublieft een geldig nummer in.";
            break;
        }

        if (strlen($name) > 255 || strlen($reason) > 255) {
            $errorMsg = "Naam of reden is te lang";
            break;
        }

        $query = "INSERT INTO students (student_name, student_class, minutes, reason) VALUES ('$name', '$class', '$minutes', '$reason')";
        $result = $connection->query($query);

        if (!$result) {
            $errorMsg = "Er is iets fout gegaan $connection->error";
            break;
        }

        $successMsg = "Student added seccussfully";

        header("location: /crud/index.php");
        exit;

    } while (false);

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nieuw student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">

</head>
<body>
<div class="container my-5">
    <h2>Een student toevogen</h2>

    <?php

    if (!empty($errorMsg)) {
        echo "
        
        <div class='alert alert-warning alert-dismissible fade show' role='alert'> 
        
        <strong>$errorMsg</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        
        
        ";
    }

    ?>

    <form method="post" action="/crud/create.php">
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="name">Naam student</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" id="name">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="class">Klas</label>
            <div class="col-sm-6">
                <select class="form-control" name="class" id="class">
                    <option value="1">2D</option>
                    <option value="2">2C</option>
                    <option value="3">2A</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="minutes">Aantal minuten te laat</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="minutes" id="minutes">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label" for="reason">Reden te laat komen:</label>
            <div class="col-sm-6">
                <textarea class="form-control" rows="3" name="reason" id="reason"></textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-primary" href="/crud/index.php" role="button">Sluiten</a>
            </div>
        </div>
    </form>

    <?php

    if (!empty($successMsg)) {
        echo "
        
        <div class='alert alert-success alert-dismissible fade show' role='alert'> 
        <strong>$successMsg</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>