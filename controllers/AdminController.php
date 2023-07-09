<?php

include(dirname(dirname(__FILE__)) . '/core/Database.php');
include(dirname(dirname(__FILE__)) . '/models/Customer.php');
include(dirname(dirname(__FILE__)) . '/models/Address.php');

class AdminController
{
    private $modelCustomerAdmin;
    private $modelAddressAdmin;
    private $errorAdmin;

    public function __construct()
    {
        $this->modelCustomerAdmin = new Customer();
        $this->modelAddressAdmin = new Address();
        $this->setErrorAdmin('');
    }

    public function truncateTables(): bool
    {
        if (!$this->modelAddressAdmin->truncateAdress()) {
            $this->setErrorAdmin('FHELR: beim Trunncate der DB Tabelle: ' . $this->modelAddressAdmin->getTableAddress());
        } else if (!$this->modelCustomerAdmin->truncateCustomer()) {
            $this->setErrorAdmin('FHELR: beim Trunncate der DB Tabelle: ' . $this->modelCustomerAdmin->getTableCustomer());
            return false;
        }
        return true;
    }

    public function setDummyData()
    {
        $dummyData = array(
            array('Herr', 'Test', 'Tester', '10.10.1980', 'test@tester.de', '+49401234567', 'Teststr. 10', '12345', 'Testort'),
            array('Frau', 'Testine', 'Tester', '11.11.1980', 'testine@test.com', '+4940987654', 'teststr. 11', '65412', 'Teststadt'),
            array('Herr', 'Mac', 'System', '24.01.1984', 'one@mac.de', '+498001234567', 'Macstr. 1', '95124', 'Appstadt')
        );
        for ($i = 0; $i < count($dummyData); $i++) {

            $this->modelCustomerAdmin->setNameSalutation($dummyData[$i][0]);
            $this->modelCustomerAdmin->setNameFirst($dummyData[$i][1]);
            $this->modelCustomerAdmin->setNameLast($dummyData[$i][2]);
            $this->modelCustomerAdmin->setBirthday($dummyData[$i][3]);
            $this->modelCustomerAdmin->setEmailFirst($dummyData[$i][4]);
            $this->modelCustomerAdmin->setPhoneFirst($dummyData[$i][5]);

            $this->modelAddressAdmin->setStreetNr($dummyData[$i][6]);
            $this->modelAddressAdmin->setPostcode($dummyData[$i][7]);
            $this->modelAddressAdmin->setCity($dummyData[$i][8]);

            if (!$this->modelCustomerAdmin->saveCustomer()) {
                $this->setErrorAdmin('error', 'FEHLER beim der Kundenverarbeitung!');
            } else {
                $this->modelAddressAdmin->setCustomerID($this->modelCustomerAdmin->getCustomerID());

                if (!$this->modelAddressAdmin->saveAddress()) {
                    $this->setErrorAdmin('error', 'FEHLER bei der Adressverarbeitung!');
                    if (!$this->modelCustomerAdmin->deleteCustomer()) {
                        $this->setErrorAdmin('error', 'FEHLER bei der entfernen der Kundenregietrierung!');
                    }
                }
            }
        }
        return true;
    }

    // get a List of Customer with theAddress
    public function getCustomerList()
    {
        $customersArr = $this->modelCustomerAdmin->getAllCustomers();
        if (count($customersArr) == 0) {
            $this->setErrorAdmin('Keine Daten vorhanden!');
        }
        return $customersArr;
    }

    // generate HTML Table line for the CustomerData
    public function showCustomerList($arrLlist)
    {
        $htmlString = "";
        for ($i = 0; $i < count($arrLlist); $i++) {
            $htmlString .= "<tr>";
            foreach ($arrLlist[$i] as $key => $customer) {
                if ($key != 'customer_id') {
                    $htmlString .= "<td>$customer</td>";
                }
            }
            $htmlString .= "</tr>";
        }
        return $htmlString;
    }

    public function setErrorAdmin($error): self
    {
        $this->errorAdmin = $error;

        return $this;
    }

    public function getErrorAdmin(): string
    {
        return $this->errorAdmin;
    }
}
