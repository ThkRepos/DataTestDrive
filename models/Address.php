<?php

class Address extends Database
{
    private $customerID;
    private $streetNr;
    private $postcode;
    private $city;

    private $tableAddress = 'address';

    public function saveAddress(): bool
    {
        try {
            $this->connectDB()
                ->prepare(
                    "INSERT INTO " . $this->tableAddress . " (customer_id, street_nr, postcode, city) VALUES (?,?,?,?)"
                )
                ->execute(
                    [$this->customerID, $this->streetNr, $this->postcode, $this->city]
                );
            return true;
        } catch (PDOException $e) {
            $this->setErrorDB($e->getMessage() . $e->getCode());
            if (APP_MODE == 'debug') {
                echo $this->getErrorDB();
            } else {
                //email info an admin 
            }
        }
        return false;
    }

    // setter & getter section
    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function setCustomerID($customerID): self
    {
        $this->customerID = $customerID;

        return $this;
    }

    public function getStreetNr()
    {
        return $this->streetNr;
    }

    public function setStreetNr($streetNr): self
    {
        $this->streetNr = $streetNr;

        return $this;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setPostcode($postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTableAddress()
    {
        return $this->tableAddress;
    }

    public function truncateAdress()
    {
        try {
            $this->connectDB()
                ->prepare("DELETE FROM " . $this->tableAddress . " WHERE id>?")
                ->execute(["0"]);
            return true;
        } catch (PDOException $e) {
            $this->setErrorDB($e->getMessage());
            if (APP_MODE == 'debug') {
                echo $this->getErrorDB();
            } else {
                //email info an admin
            }
        }
        return false;
    }
}
