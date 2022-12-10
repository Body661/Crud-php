<?php

$show = "not";

function showModal()
{
    $show = true;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container my-5">
    <h2>Overzicht studenten die laat waren</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Naam student</th>
            <th>Klas</th>
            <th>Minuten te laat</th>
            <th>Reden te laat</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php
        include "connect.php";

        $query = "SELECT * FROM students INNER JOIN class ON students.student_class = class.class_id";
        $result = $connection->query($query);

        if (!$result) {
            die("Something went wrong: $connection->error");
        }

        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                        <td>$row[student_name]</td>
                        <td>$row[class_name]</td>
                        <td>$row[minutes]</td>
                        <td>$row[reason]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/crud/edit.php?id=$row[student_id]'>Bewerken</a>
                            <a type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#exampleModalCenter' onclick='doConfirm(`$row[student_id]`)'>Verwijder</a>
                        </td>
                    </tr>";
        }
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary my-2" href="/crud/create.php">Weer eentje te laat</a>

    <hr>

    <table class="table my-4">

        <h6>Statistieken</h6>

        <tbody>
        <?php
        $query = "SELECT MAX(minutes) AS maximum, AVG(minutes) AS average, SUM(minutes) AS minSum FROM students";
        $result = $connection->query($query);

        if (!$result) {
            die("Something went wrong: $connection->error");
        }

        $row = $result->fetch_assoc();


        echo "
        <tr>
            <td>Hoogste aantal minuten te laat</td>
            <td>$row[maximum]</td>
        </tr>
        <tr>
            <td>Gemiddeld aantal minuten</td>
            <td>$row[average]</td>
        </tr>
        <tr>
            <td>Totaal aantal minuten</td>
            <td>$row[minSum]</td>
        </tr>" ?>
        </tbody>
    </table>

    <script>
        async function doConfirm(id) {
            let ok = confirm("Weet u zeker dat u dit wilt verwijderen?");
            if (ok) {
                const res = await fetch(`/crud/delete.php?id=${id}`)
                location.reload();

                if (!res.ok) {
                    console.log("something went wrong!")
                }
            }
        }
    </script>
</body>

</html>