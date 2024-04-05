<?php
@include_once(__DIR__ . '/src/Helpers/Message.php');
@include_once(__DIR__ . '/src/Database/Database.php');
@include_once(__DIR__ . '/template/head.inc.php');
@include_once(__DIR__ . '/src/Helpers/LoginAndOutHandler.php');

$errors = []; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    if (empty($_POST['email'])) {
        $errors[] = "Email is required.";
    }

    if (empty($_POST['password'])) {
        $errors[] = "Password is required.";
    }

    // Proceed only if there are no validation errors
    if (empty($errors)) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the provided email exists in the database
        Database::query("SELECT * FROM `customers` WHERE `email` = :email", [':email' => $email]);
        $customer = Database::get();

        if ($customer) {
            // Verify the provided password
            if (password_verify($password, $customer->password)) {
                // Passwords match, proceed with login
                if (login($customer)) {
                    // Set success message and redirect to last visited page
                    setMessage('success', 'U bent succesvol ingelogd.');
                    header('Location: index.php');
                    exit();
                } else {
                    // Error occurred during login
                    setError('credentials-error', 'Er is iets fout gegaan tijdens het inloggen. Probeer a.u.b. nog eens...');
                    header('Location: index.php');
                    exit();
                }
            } else {
                // Passwords do not match
                setError('credentials-error', 'De ingevoerde credentials komen niet overeen met onze gegevens. Probeer a.u.b. opnieuw...');
                header('Location: login.php');
                exit();
            }
        } else {
            // Email not found in the database
            $errors[] = "Email is not registered.";
        }
    }
}
?>

<?php include_once(__DIR__ . '/template/head.inc.php'); ?>

<main class="uk-container uk-padding">
    <form method="POST" action="login.php" class="uk-width-1-1 uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-3-5 uk-padding-small">
            <div class="uk-card-header">
                <h2 class="uk-text-uppercase">Inloggen</h2>
            </div>
            <?php if (!empty($errors)): ?>
            <div class="uk-alert-danger" uk-alert>
                <a href class="uk-alert-close" uk-close></a>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <div class="uk-card-body uk-flex uk-flex-between uk-card-body-gap">
                <div class="uk-width-1-3">
                    <img src="img/logo4.png" class="uk-card-media uk-card-body-login-logo" alt="Webshop Het Witte Kippetje" title="Webshop Het Witte Kippetje" />
                    <div class="uk-flex uk-flex-column uk-flex-middle">
                        <p class="uk-text-center uk-margin-remove-bottom uk-text-muted">Webshop</p>
                        <h4 class="uk-text-uppercase uk-text-center uk-margin-remove-vertical uk-text-muted">Het Witte Kippetje</h4>
                    </div>
                </div>
                <div class="uk-width-2-3 uk-flex uk-flex-column">
                    <div class="uk-padding">
                        <label for="email" class="uk-form-label">Email<span class="uk-text-xsmall uk-text-italic uk-text-primary"> (Verplicht)</span></label>
                        <input type="email" name="email" class="uk-input" id="email" placeholder="E-mail adres..." />
                        <?php if (!empty($errors) && empty($_POST['email'])): ?>
                        <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">Bericht als dit veld niet ingevuld is</p>
                        <?php endif; ?>
                    </div>
                    <div class="uk-padding">
                        <label for="password" class="uk-form-label">Wachtwoord<span class="uk-text-xsmall uk-text-italic uk-text-primary"> (Verplicht)</span></label>
                        <input type="password" name="password" class="uk-input" id="password" placeholder="Wachtwoord..." />
                        <?php if (!empty($errors) && empty($_POST['password'])): ?>
                        <p class="uk-text-danger uk-text-xsmall uk-text-italic uk-margin-remove-vertical">Bericht als dit veld niet ingevuld is</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="uk-card-footer uk-flex uk-flex-between">
                <a href="#" class="">Wachtwoord vergeten?</a>
                <button class="uk-button uk-button-primary" type="submit">Inloggen</button>
            </div>
        </div>
    </form>
</main>

<?php include_once(__DIR__ . '/template/foot.inc.php'); ?>
