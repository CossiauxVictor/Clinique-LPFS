<?php
// Start a PHP session to track login attempts
session_start();
session_destroy();
session_start();

$erreur='';


// Check if the form was submitted

if (isset($_POST['mail']) && isset($_POST['password']) && strlen($_POST['h-captcha-response'])!=0) {
    $captcha_secret_key = 'fe669db7-d4d2-4a64-88ca-f41f0e3b938c'; // Remplacez par votre clé secrète hCaptcha
    
    echo strlen($_POST['h-captcha-response']) ;
    // Effectuer une vérification hCaptcha en envoyant la réponse au serveur hCaptcha
    $url = 'https://hcaptcha.com/siteverify';
    
    

    $data = [
        'secret' => $captcha_secret_key,
        'response' => $captcha_response,
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    
    if(strlen ($_POST['h-captcha-response'])<10){
        $captcha_response = 'AZERTYUJCABU';
    }else{
        $captcha_response = $_POST['h-captcha-response'];
    }
    $captcha_response_correct = $_POST['g-recaptcha-response'];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $captcha_data = json_decode($result);

    // Define the maximum number of login attempts and the lockout duration
    $maxAttempts = 5;
    $lockoutDuration = 30; // 1 minute in seconds
    // Check if the user is currently locked out
    if (isset($_SESSION['login_attempts']) && isset($_SESSION['lockout_time'])) {
        $currentTime = time();
        $lockoutTime = $_SESSION['lockout_time'];

        // Check if the lockout duration has passed
        if (($currentTime - $lockoutTime) < $lockoutDuration) {
            // Display an error message and exit
            echo '<label for="mail">*Vous êtes bloqué pendant une minute. Réessayez plus tard.</label>';
            ?>
            <form action='connexion.php'><input type='submit' value='restart'></form>
            <?php
            exit;
        } else {
            // Reset the login attempts and lockout time
            $_SESSION['login_attempts'] = 0;
            unset($_SESSION['lockout_time']);
        }
    }

    // Database connection
    require_once('config.php');

    // SQL query to retrieve user data
    $sql_user = "SELECT * FROM user;";
    $result_user = mysqli_query($mysqli, $sql_user);

    // Flag to track if login is successful
    $loginSuccessful = false;

    
    $hachage = hash('sha256', $_POST['password']);

    while ($row_user = mysqli_fetch_array($result_user, MYSQLI_NUM)) {
        if (($row_user[3] == $_POST['mail']) && ($row_user[4] == $hachage)) {
            $_SESSION['Test_Premier_Co']=$row_user[7];
            $_SESSION['Id_User']=$row_user[0];
            $_SESSION['Date_Mdp']=$row_user[8];
            $_SESSION['MDP']=$row_user[4];
            $_SESSION['Role']=$row_user[6];
            $loginSuccessful = true;
            break; // Exit the loop when a matching user is found
        }
    }

    // Close the database connection
    mysqli_close($mysqli);

    // Check if login was successful
    if ($loginSuccessful) {


        // Reset the login attempts
        $_SESSION['login_attempts'] = 0;
        unset($_SESSION['lockout_time']);
        


        if($captcha_response==$captcha_response_correct){
            //--------------------------------------------------------------------------Tout doit mettre les id des role-------------------------------------------------------
            header("Location: mdp.php");
            exit;
        }

        // Redirect to a successful login page
        
    } else {
        // Increment the login attempts
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
        } else {
            $_SESSION['login_attempts']++;
        }

        // Check if the maximum login attempts have been reached
        if ($_SESSION['login_attempts'] >= $maxAttempts) {
            // Set the lockout time
            $_SESSION['lockout_time'] = time();
            
            // Display an error message
            $erreur='<label for="mail">*Vous avez dépassé le nombre maximum de tentatives de connexion. Réessayez dans une minute.</label>';
        } else {
            // Display a regular error message
            $erreur='<label for="mail">*Erreur Adresse mail ou Mot de passe est incorrect</label>';
        }
    }
}else{
    $erreur='Vous avait pas tout renplie !';
    
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- META -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- LINKS -->
    <link rel="stylesheet" href="src/css/connexion.css">

    <!-- TITLE -->
    <title> Formulaire de connexion </title>
</head>
<body>
    <!-- FORMULAIRE DE CONNEXION -->
    <div class="formulaire_login">
        <form method="post" class="connexion" action="connexion.php"> 
            <h1> Connexion </h1>
            <div class="div_formulaire" action="connexion.php">
                <input type="text" class="form_input" placeholder="Adresse mail" name="mail" required>
            </div>
            <div class="div_formulaire">
                <input type="password" class="form_input" placeholder="Mot de passe" name="password" required>
            </div>
            <div class="h-captcha" data-sitekey="fe669db7-d4d2-4a64-88ca-f41f0e3b938c"></div>
            <input type="submit" value="connexion" class="form_button" name="valider">
        </form>
    </div>
</body>
</html>

<script src="https://hcaptcha.com/1/api.js" async defer></script>
