<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/formulaire.css">
    <link rel="stylesheet" href="../css/otp.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="body">
    <img src="../imgs/1a77f09b-7469-418d-99fc-5e3836d66109.jfif" class="imgleft" alt="">
    <img src="../imgs/888053ee-b563-480c-912d-997fb5c6eb0b.jfif" class="img2" alt="">
    <div class="form-container">
        <div class="form-group"> <br>
            <form action="../php/otp.php" method="post">
                <input type="number" id="inputver" name="codeutil" placeholder="saisir le code ">
                <span style="color: rgb(255, 131, 131);">verifier votre email et saisir le code </span>
                <button class="button" name="submit" type="submit">valider</button>
            </form>
        </div>
    </div>


</body>

</html>