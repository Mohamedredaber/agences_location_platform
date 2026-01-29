<?php
session_start();
if (isset($_SESSION['error_info_invalid'])) {
    echo "<script>alert('" . addslashes($_SESSION['error_info_invalid']) . "');</script>";
    unset($_SESSION['error_info_invalid']); 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <img src="../imgs/téléchargement (3).jfif" class="img1" alt="">
    <img src="../imgs/newtéléchargement (4).jpg"  class="img2" alt="">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="login-form">
                    <h2 class="text-center text-light mb-4">HELLO</h2>
                    <form action="../php/login.php" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label><br>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                minlength="6">
                        </div>
                        <button type="submit" class="btn btn-danger btn-block" style="color: rgb(0, 0, 0);">Login</button>
                        <div class="text-center mt-3">
                            <span class="text-muted">Je n'ai pas de compte</span>
                            <a href="../html/verifierht.php" class="text-danger ml-2">S'inscrire</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>