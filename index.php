<?php
include(dirname(__FILE__) . '/core/config.inc.php');
include(dirname(__FILE__) . '/controllers/IndexController.php');

$controller = new IndexController();
$success = 0;
$formData = array();
$formError = array();

if (isset($_POST['action']) && $_POST['action'] == 'submit') {
    if ($controller->checkSubmit()) {
        $success = 2;
    } else {
        $formError = $controller->getErrorIndex();
        $formData  = $controller->getDataIndex();
    }
}
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo WEBPAGE_NAME ?> - <?php echo ($success == 2) ? 'Erfolgreich' : 'Registrierung'; ?></title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles template -->
<link href="assets/css/site_index.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <?php if (isset($formError['error']) &&  strlen($formError['error']) > 3) : ?>
        <main class="container">
            <div class="bg-warning p-5 rounded mt-3 text-lg-center">
                <h1 class="text-dark mb-4">FEHLER bei Ihrer Registrierung!</h1>
                <p class="text-dark">
                    <?php echo $formError['error']; ?>
                </p>
            </div>
            <div>
                <p class="mt-2 mb-3 text-body-secondary">&copy; TestDrive 2023 -- <a href="<?php APP_URL; ?>">Wiederholen?</a></p>
            </div>
        </main>
    <?php endif; ?>
    <?php if ($success == 2) : ?>
        <main class="container">
            <div class="bg-success p-5 rounded mt-3 text-lg-center" oncklick="location.href='<?php echo APP_URL; ?>'">
                <h1 class="text-light mb-4">Ihre Registrierung war erfolgreich!</h1>
                <p>
                    <i class="">
                        <svg xmlns="http://www.w3.org/2000/svg" height="6em" viewBox="0 0 512 512">
                            <style>
                                svg {
                                    fill: #ffffff
                                }
                            </style>
                            <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z" />
                        </svg>
                    </i>
                </p>
            </div>
            <div>
                <p class="mt-2 mb-3 text-body-secondary">&copy; TestDrive 2023 -- <a href="<?php APP_URL; ?>/admin.php">ADMIN-Section</a></p>
            </div>
        </main>
    <?php endif; ?>
    <?php if ($success == 0 && !isset($formError['error'])) : ?>
        <div class="container mt-1">
            <main class="form-signin m-auto">
                <h1 class="text-body-emphasis">Registrierung</h1>
                <form method="POST" name="register" action="<?php echo APP_URL ?>">
                    <input type="hidden" class="form-control" name="action" value="submit">
                    <h4 class="mb-3 fw-normal">Bitte füllen Sie alle Felder aus.</h4>
                    <div class="form-floating mb-3">
                        <input type="text" id="name_salutation" maxlength="10" name="name_salutation" placeholder="Anrede" class="form-control<?php echo (isset($formError['name_salutation'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['name_salutation'])) ? $formData['name_salutation'] : ''; ?>">
                        <label for="name_salutation">Anrede</label>
                        <span class="invalid-feedback"><?php echo (isset($formError['name_salutation'])) ? $formError['name_salutation'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="text" id="name_first" maxlength="50" name="name_first" placeholder="Vorname" class="form-control<?php echo (isset($formError['name_first'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['name_first'])) ? $formData['name_first'] : ''; ?>">
                        <label for="name_first">Vorname</label>
                        <span class="invalid-feedback"><?php echo (isset($formError['name_first'])) ? $formError['name_first'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="text" id="name_last" maxlength="50" name="name_last" placeholder="Nachname" class="form-control<?php echo (isset($formError['name_last'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['name_last'])) ? $formData['name_last'] : ''; ?>">
                        <label for="name_last">Nachname</label>
                        <span class="invalid-feedback"><?php echo (isset($formError['name_last'])) ? $formError['name_last'] : ''; ?></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" id="birthday" maxlength="10" name="birthday" onKeyUp="formatBirthday();" placeholder="Geburtstag" class="form-control<?php echo (isset($formError['birthday'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['birthday'])) ? $formData['birthday'] : ''; ?>">
                        <label for="birthday">Geburtstag (Format: ddmmyyy)</label>
                        <span id="sp_birthday" class="invalid-feedback"><?php echo (isset($formError['birthday'])) ? $formError['birthday'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="email" id="email_first" maxlength="75" name="email_first" onblur="checkEmail(this.id);" placeholder="Email" class="form-control<?php echo (isset($formError['email_first'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['email_first'])) ? $formData['email_first'] : ''; ?>">
                        <label for="email_first">E-Mail (Format: name@domain/dienst.2/3 Zeichen )</label>
                        <span id="sp_email_first" class="invalid-feedback"><?php echo (isset($formError['email_first'])) ? $formError['email_first'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="text" id="phone_first" maxlength="20" name="phone_first" onkeyup="checkNumField(this.id);" placeholder="040123456" class="form-control<?php echo (isset($formError['phone_first'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['phone_first'])) ? $formData['phone_first'] : ''; ?>">
                        <label for="phone_first">Telefon (Format: 0150123123)</label>
                        <span id="sp_phone_first" class="invalid-feedback"><?php echo (isset($formError['phone_first'])) ? $formError['phone_first'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="text" id="street_nr" maxlength="60" name="street_nr" placeholder="Straße Nr." class="form-control<?php echo (isset($formError['street_nr'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['street_nr'])) ? $formData['street_nr'] : ''; ?>">
                        <label for="street_nr">Straße Nr.</label>
                        <span class="invalid-feedback"><?php echo (isset($formError['street_nr'])) ? $formError['street_nr'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="text" id="postcode" maxlength="7" name="postcode" onkeyup="checkNumField(this.id);" placeholder="Postlitzahl" class="form-control<?php echo (isset($formError['postcode'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['postcode'])) ? $formData['postcode'] : ''; ?>">
                        <label for="postcode">Postleitzahl</label>
                        <span id="sp_postcode" class="invalid-feedback"><?php echo (isset($formError['postcode'])) ? $formError['postcode'] : ''; ?></span>
                    </div>
                    <div class="form-floating  mb-3">
                        <input type="text" id="city" maxlength="50" name="city" onkeyup="checkTextField(this.id);" placeholder="Wohnort" class="form-control<?php echo (isset($formError['city'])) ? ' is-invalid' : ''; ?>" value="<?php echo (isset($formData['city'])) ? $formData['city'] : ''; ?>">
                        <label for="city">Wohnort</label>
                        <span id="sp_city" class="invalid-feedback"><?php echo (isset($formError['city'])) ? $formError['city'] : ''; ?></span>
                    </div>

                    <button class="btn btn-primary w-100 py-2" type="submit">Absenden</button>
                    <p class="mt-2 mb-3 text-body-secondary">&copy; TestDrive 2023 -- <a href="<?php APP_URL; ?>/admin.php">ADMIN-Section</a></p>
                </form>
            <?php endif; ?>
            </main>
        </div>
        <script src="assets/js/bundle.min.js"></script>
        <script type="text/javascript" src="assets/js/index.js"></script>
</body>

</html>
<?php ($success == 2) ?? session_destroy(); ?>