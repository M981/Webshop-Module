<?php
@include_once(__DIR__.'/src/Helpers/Auth.php');
@include_once(__DIR__.'/src/Helpers/Message.php');
@include_once(__DIR__.'/src/Database/Database.php');
@include_once(__DIR__ . '/template/head.inc.php');

$errors = []; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted
    $firstname = htmlspecialchars($_POST['firstname']);
    $prefixes = htmlspecialchars($_POST['prefixes']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $street = htmlspecialchars($_POST['street']);
    $housenumber = htmlspecialchars($_POST['housenumber']);
    $addition = htmlspecialchars($_POST['addition']);
    $zipcode = htmlspecialchars($_POST['zipcode']);
    $city = htmlspecialchars($_POST['city']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Perform validation
    if (empty($firstname) || empty($lastname) || empty($street) || empty($housenumber) || empty($zipcode) || empty($city) || empty($email) || empty($password) || empty($password_confirm)) {
        $errors[] = "All fields are required.";
    }

    if ($password !== $password_confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email is already registered
    Database::query("SELECT * FROM `customers` WHERE `email` = :email", [':email' => $email]);
    if (Database::get()) {
        $errors[] = "Email is already registered.";
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $user_data = [
            'firstname' => $firstname,
            'prefixes' => $prefixes,
            'lastname' => $lastname,
            'street' => $street,
            'house_number' => $housenumber,
            'addition' => $addition,
            'zipcode' => $zipcode,
            'city' => $city,
            'email' => $email,
            'password' => $hashed_password
        ];
        
        $result = Database::insert('customers', $user_data);
        
        if ($result) {
            // Redirect to login page or any other page
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Error occurred during registration.";
        }
    }
}
?>

<main class="uk-container uk-padding">
    <div class="uk-width-1-1 uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-4-5 uk-padding-small">
            <h2 class="uk-card-title">Registratieformulier</h2>
            <form method="POST" action="src/Formhandlers/register.php">
                <?php if (!empty($errors)): ?>
                    <div class="uk-alert-danger" uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="uk-margin">
                    <label class="uk-form-label" for="firstname">Voornaam:</label>
                    <input class="uk-input" type="text" id="firstname" name="firstname" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="prefixes">Tussenvoegsel:</label>
                    <input class="uk-input" type="text" id="prefixes" name="prefixes">
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="lastname">Achternaam:</label>
                    <input class="uk-input" type="text" id="lastname" name="lastname" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="street">Straat:</label>
                    <input class="uk-input" type="text" id="street" name="street" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="housenumber">Huisnummer:</label>
                    <input class="uk-input" type="text" id="housenumber" name="housenumber" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="addition">Toevoeging:</label>
                    <input class="uk-input" type="text" id="addition" name="addition">
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="zipcode">Postcode:</label>
                    <input class="uk-input" type="text" id="zipcode" name="zipcode" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="city">Woonplaats:</label>
                    <input class="uk-input" type="text" id="city" name="city" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="email">E-mail:</label>
                    <input class="uk-input" type="email" id="email" name="email" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="password">Wachtwoord:</label>
                    <input class="uk-input" type="password" id="password" name="password" required>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="password_confirm">Bevestig Wachtwoord:</label>
                    <input class="uk-input" type="password" id="password_confirm" name="password_confirm" required>
                </div>

                <div class="uk-margin">
                    <button class="uk-button uk-button-primary" type="submit">Registreer</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php
include_once(__DIR__ . '/template/foot.inc.php');
?>
