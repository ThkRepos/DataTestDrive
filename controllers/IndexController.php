<?php

include(dirname(dirname(__FILE__)) . '/core/Database.php');
include_once(dirname(dirname(__FILE__)) . '/models/Address.php');
include_once(dirname(dirname(__FILE__)) . '/models/Customer.php');

class IndexController
{
    private $modelCustomer;
    private $modelAddress;
    private $errorIndex = [];
    private $dataIndex = [];

    public function __construct()
    {
        $this->modelCustomer = new Customer();
        $this->modelAddress  = new Address();
    }

    public function checkSubmit(): bool
    {
        if ($this->validateRegisterForm()) {
            if (!$this->modelCustomer->saveCustomer()) {
                $this->addErrorIndex('error', 'FEHLER beim der Kundenverarbeitung!');
            } else {
                $this->modelAddress->setCustomerID($this->modelCustomer->getCustomerID());

                if (!$this->modelAddress->saveAddress()) {
                    $this->addErrorIndex('error', 'FEHLER bei der Adressverarbeitung!');
                    if (!$this->modelCustomer->deleteCustomer()) {
                        $this->addErrorIndex('error', 'FEHLER bei der entfernen der Kundenregietrierung!');
                    }
                } else {
                    return true;
                }
            }
        }
        return false;
    }

    // validate user input 
    protected function validateRegisterForm(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            // Formular verarbeiten
            if (empty($_POST['name_salutation'])) {
                $this->addErrorIndex('name_salutation', 'Bitte füllen Sie das Feld Anrede aus!');
            } else {
                $this->modelCustomer->setNameSalutation(trim($_POST['name_salutation']));
            }
            if (empty($_POST['name_first'])) {
                $this->addErrorIndex('name_first', 'Bitte füllen Sie das Feld Vorname aus!');
            } else {
                $this->modelCustomer->setNameFirst(trim($_POST['name_first']));
            }
            if (empty($_POST['name_last'])) {
                $this->addErrorIndex('name_last', 'Bitte füllen Sie das Feld Nachname aus!');
            } else {
                $this->modelCustomer->setNameLast(trim($_POST['name_last']));
            }
            if (empty($_POST['birthday'])) {
                $this->addErrorIndex('birthday', 'Bitte füllen Sie das Feld Gebirtstag aus!');
            } else {
                $this->modelCustomer->setBirthday(trim($_POST['birthday']));
            }
            if (empty($_POST['email_first'])) {
                $this->addErrorIndex('email_first', 'Bitte füllen Sie das Feld Email aus!');
            } else {
                if (!filter_var($_POST['email_first'], FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorIndex('email_first', 'Bitte passen Sie Ihre Email an, Ihre eingabe hat ein falsches Format!');
                } else {
                    $this->modelCustomer->setEmailFirst(trim($_POST['email_first']));
                }
            }
            if (empty($_POST['phone_first'])) {
                $this->addErrorIndex('phone_first', 'Bitte füllen Sie das Feld Telefon aus!');
            } else {
                $this->modelCustomer->setPhoneFirst(CUSTOMER_PHONECODE . "" . substr(trim($_POST['phone_first']), 1));
            }
            if (empty($_POST['street_nr'])) {
                $this->addErrorIndex('street_nr', 'Bitte füllen Sie das Feld Straße, Nr aus!');
            } else {
                $this->modelAddress->setStreetNr(trim($_POST['street_nr']));
            }
            if (empty($_POST['postcode'])) {
                $this->addErrorIndex('postcode', 'Bitte füllen Sie das Feld Postleitzahl aus!');
            } else {
                $this->modelAddress->setPostcode(trim($_POST['postcode']));
            }
            if (empty($_POST['city'])) {
                $this->addErrorIndex('city', 'Bitte füllen Sie das Feld Ort aus!');
            } else {
                $this->modelAddress->setCity(trim($_POST['city']));
            }
            if (count($this->errorIndex) > 0) {
                $this->setDataIndex($_POST);
            } else {
                return true;
            }
        }
        return false;
    }

    // setter & getter section
    public function addErrorIndex($fieild, $text)
    {
        $this->errorIndex[$fieild] = $text;
    }

    public function getModelCustomer()
    {
        return $this->modelCustomer;
    }

    public function getErrorIndex()
    {
        return $this->errorIndex;
    }

    public function setErrorIndex($error): self
    {
        $this->errorIndex = $error;

        return $this;
    }

    public function getModelAddress()
    {
        return $this->modelAddress;
    }

    public function getDataIndex()
    {
        return $this->dataIndex;
    }

    public function setDataIndex($data): self
    {
        $this->dataIndex = $data;

        return $this;
    }
}
