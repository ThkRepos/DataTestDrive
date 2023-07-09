<?php

include(dirname(__FILE__) . '/core/config.inc.php');
include(dirname(__FILE__) . '/controllers/AdminController.php');

$controllerAdmin = new AdminController();
$listCustomers = $controllerAdmin->getCustomerList();
$countCustomer   = count($listCustomers);
$data            = json_encode($listCustomers);
//var_dump($listCustomers);
if (isset($_REQUEST['trunc']) && $countCustomer > 0) {
    if (!$controllerAdmin->truncateTables()) {
        $controllerAdmin->setErrorAdmin('DB leeren wurde ein Fehler gemeldet! Wieederholen?');
    } else {
        header('Location: ' . APP_URL . '/admin.php');
        die;
    }
} else if (isset($_REQUEST['dummy']) && $countCustomer == 0) {
    if ($controllerAdmin->setDummyData()) {
        $controllerAdmin->setErrorAdmin('DB mit daten befüllt!');
        header('Location: ' . APP_URL . '/admin.php');
        die;
    }
} else if (isset($_REQUEST['show']) && $countCustomer > 0) {
    header('Content-type: application/json; charset=utf-8');
    echo $data;
    die;
} else if (isset($_REQUEST['load']) && $countCustomer > 0) {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename=' . date("Y_m_d_H_i_s_") . ' Custom_Data.json');
    header("Content-Length: " . strlen($data));
    echo $data;
    die;
}
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo WEBPAGE_NAME ?> - Admin</title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main class="container">
        <?php if (strlen($controllerAdmin->getErrorAdmin()) > 0) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>FEHLER: </strong> <?php echo $controllerAdmin->getErrorAdmin(); ?>
                <?php if ($countCustomer == 0) : ?>
                    <a class="link" href="<?php echo APP_URL; ?>/admin.php?dummy" target="_blank">DB befüllen</a>
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="bg-body-tertiary p-5 rounded">
            <h1>Datenliste: <?php echo $countCustomer; ?></h1>
            <div class="table-responsive small">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Pos-ID</th>
                            <th scope="col">Anrede</th>
                            <th scope="col">Vorname</th>
                            <th scope="col">Nachname</th>
                            <th scope="col">Geburtstag</th>
                            <th scope="col">Email</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Straße Nr.</th>
                            <th scope="col">Postleitzahl</th>
                            <th scope="col">Wohnort</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $controllerAdmin->showCustomerList($listCustomers); ?>
                    </tbody>
                </table>
            </div>
            <?php if ($countCustomer > 0) : ?>
                <div class="dropdown text-end">
                    <button class="btn btn-secondary dropdown-toggle disable" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data-Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/admin.php?show" target="_blank">Anzeigen</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/admin.php?load" target="_blank">Download</a></li>
                        <?php if ($countCustomer > 0) : ?>
                            <li><a class="dropdown-item" href="<?php echo APP_URL; ?>/admin.php?trunc" target="_blank">Leere DB</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script src="assets/js/bundle.min.js"></script>
    <script>
        const alertList = document.querySelectorAll('.alert')
        const alerts = [...alertList].map(element => new bootstrap.Alert(element))
    </script>
</body>

</html>