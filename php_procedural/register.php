<?php

// Include config file
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// processamento dei dati del form di registrazione
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // TODO: rifattorizzare creando un file di funzioni che racchiude tutte le funzioni di validazione

    ///////////////////////////////////////////////////////////
    // validazione dello username: verifico che il field dello
    // username non sia stato lasciato in bianco, vuoto ecc...
    ///////////////////////////////////////////////////////////

    if(empty(trim($_POST["username"]))){
        $username_err = "Per favore inserisci uno username valido.";
    } else {
        // inserimento dello username
        $sql = "SELECT id FROM users WHERE username = ?";
        // prepared statement -> Prepare an SQL statement for execution
        if($stmt = mysqli_prepare($connection, $sql)){
            // Binds variables to a prepared statement as parameters -> qui assegno lo username alla query
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Settaggio dello username prendendo il parametro in input dal form
            $param_username = trim($_POST["username"]);
            // esecuzione dello statement SQL -> Seleziona l'id dello username dove lo username vale = "username"
            if(mysqli_stmt_execute($stmt)){
                /* store dei risultati */
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Username già esistente, devi sceglierne un altro.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }







    // Close connection
    mysqli_close($connection);
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrapper">
    <h2>Sign Up</h2>
    <p>Compila questo form per creare un nuovo account.</p>
    <form action="#" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="">
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="">
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" value="">
            <span class="invalid-feedback"></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
        <p>Already have an account? <a href="#">Login here</a>.</p>
    </form>
</div>
</body>
</html>
