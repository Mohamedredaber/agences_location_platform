<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenc Information Form</title>
    <link rel="stylesheet" href="../css/formulaire.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="body">
    <!-- <img class="image" src="img/logo-class-pour-location-de-voiture-1.jpg" alt=""> -->
    <img src="../imgs/téléchargement (6).jfif" alt="" class="image">
    <div class="form-container">
        <h1>INSCRIPTION</h1>
        <center>
            <!-- <button class="btn btn-primary">hello</button> -->
            <div class="row">
                <div class="col">
                    <form action="../php/formulaire.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="agencName">Nom de l’agence </label>
                            <input required type="text" id="agencName" name="agencName">
                        </div>

                        <div class="form-group">
                            <label for="email">Adresse e-mail</label>
                            <input required type="email" id="email" name="email" readonly  value='<?php echo $_SESSION['email'];?>'>
                        </div>
                        <!-- <input type="button" name="btn" value="verification du email" onclick="Ferifier()">  -->
                        <!-- <div class="form-group">
                            <label for="inputver">verification</label>
                            <input required type="number" id="inputver" name="inputver">
                            <span style="color: rgb(255, 131, 131);">verifier votre email et saisir le code </span> 
                        </div> -->

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input required type="password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="agencLogo">Logo</label>
                            <input required type="file" id="agencLogo" name="agencLogo">
                        </div>
                        <div class="form-group">
                            <label for="city">Ville(s) d’activité</label>
                            <input required type="text" id="city" name="city">
                        </div>

                        <div class="form-group">
                            <label for="phone">Numéro(s) de téléphone</label>
                            <input required type="tel" id="phone" name="phone">
                        </div>
                </div>
                <div class="col">
                    <!-- <div class="form-group">
                <label for="openingHours">Horaires d’ouverture *</label>
                <textarea id="openingHours" name="openingHours" rows="3" ></textarea>
            </div> -->

                    <div class="form-group">
                        <label>Réseaux sociaux</label>
                        <div class="social-inputs" required>
                            <input required type="url" placeholder="Facebook" name="facebook"
                                onmouseover="this.style.boxShadow='0 0 10px rgb(26, 26, 255)'"
                                onmouseout="this.style.boxShadow='none' "> <!-- ha wa7d pyasa  b js blaan -->
                            <input required type="url" placeholder="Instagram" name="instagram"
                                onmouseout="this.style.boxShadow='none'"
                                onmouseover="this.style.boxShadow='0 0 10px rgb(255, 26, 117)'">
                            <input required type="url" placeholder="LinkedIn" name="linkedin"
                                onmouseover="this.style.boxShadow='0 0 10px rgb(51, 102, 255)'"
                                onmouseout="this.style.boxShadow='none'">
                            <input required type="url" placeholder="Twitter/X" name="twitter"
                                onmouseover="this.style.boxShadow='0 0 10px rgb(0, 0, 0)'"
                                onmouseout="this.style.boxShadow='none'">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="df">Date Fin</label>
                        <input required type="time" name="datefin" id="df">
                        <label for="dd">Date Debut</label>
                        <input required type="time" name="datedebut" id="dd">

                    </div>
                    <!-- <div class="form-group">
                <label for="locationMap">Carte de localisation (Google Maps URL)</label>
                <input required type="url" id="locationMap" name="locationMap" placeholder="https://maps.google.com/..." >
            </div> -->
                </div>


                <button class="button" type="submit">Submit</button>
                </form>
            </div>
    </div>

</body>

<script>
    // Empêche l'utilisateur d'utiliser le bouton retour du navigateur
    window.history.pushState(null, "", window.location.href);
    window.addEventListener("popstate", function() {
        window.history.pushState(null, "", window.location.href);
    });
</script>


</html>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    function Ferifier()
    {
        var email = document.getElementById("email").value;
        $.ajax({
            url: 'Mail.php',
            method: 'GET',
            data: { email: email},
            success: function(response) 
            {
               alert(response);
            },
            error: function(response) 
            {
                alert(response);
            }
        });
    }
</script> -->