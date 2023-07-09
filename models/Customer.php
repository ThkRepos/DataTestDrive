<?php

class Customer extends Database
{
    private $customerID;
    private $name_salutation;
    private $name_first;
    private $name_last;
    private $birthday;
    private $email_first;
    private $phone_first;
    private $tableCustomer = 'customers';
    private $tableAddress = 'address';

    // save one Customer 
    public function saveCustomer(): bool
    {
        try {
            $this->connectDB()->beginTransaction();
            $data = [$this->name_salutation, $this->name_first, $this->name_last, $this->birthday, $this->email_first, $this->phone_first];
            $this->connectDB()
                ->prepare(
                    "INSERT INTO " . $this->tableCustomer . " (name_salutation, name_first, name_last, birthday, email_first, phone_first) VALUES (?,?,?,?,?,?)"
                )
                ->execute($data);

            if ($this->connectDB()->lastInsertId() > 0) {
                $this->setCustomerID($this->connectDB()->lastInsertId());
                $this->connectDB()->commit();
                return true;
            }
        } catch (PDOException $e) {
            $this->connectDB()->rollBack();
            $this->setErrorDB('ERROR: ' . $e->getMessage() . 'PDO-CODE: ' . $e->getCode());

            if (APP_MODE == 'debug') {
                echo $this->getErrorDB();
            } else {
                //email info an admin 
            }
        }
        return false;
    }

    // delete one Customer fk will delete the Address
    public function deleteCustomer(): bool
    {
        try {
            $this->connectDB()
                ->prepare("DELETE FROM " . $this->tableCustomer . " WHERE id=?")
                ->execute([$this->getCustomerID()]);
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

    // retuan all Customer with address
    public function getAllCustomers(): array
    {
        try {
            return $this->connectDB()
                ->query("SELECT * FROM  " . $this->tableCustomer . " LEFT JOIN " . $this->tableAddress . " ON " . $this->tableAddress . ".customer_id=" . $this->tableCustomer . ".id")
                ->fetchAll();
        } catch (PDOException $e) {
            $this->setErrorDB($e->getMessage() . $e->getCode());
            if (APP_MODE == 'debug') {
                echo $this->getErrorDB();
            } else {
                //email info an admin 
            }
        }
        return array();
    }

    // getter & setter section
    public function getPhoneFirst()
    {
        return $this->phone_first;
    }

    public function setPhoneFirst($phone_first): self
    {
        $this->phone_first = $phone_first;

        return $this;
    }

    public function getNameSalutation()
    {
        return $this->name_salutation;
    }

    public function setNameSalutation($name_salutation): self
    {
        $this->name_salutation = $name_salutation;

        return $this;
    }

    public function getNameFirst()
    {
        return $this->name_first;
    }

    public function setNameFirst($name_first): self
    {
        $this->name_first = $name_first;

        return $this;
    }

    public function getNameLast()
    {
        return $this->name_last;
    }

    public function setNameLast($name_last): self
    {
        $this->name_last = $name_last;

        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCustomerID()
    {
        return $this->customerID;
    }

    private function setCustomerID($customerID): self
    {
        $this->customerID = $customerID;

        return $this;
    }

    public function getEmailFirst()
    {
        return $this->email_first;
    }

    public function setEmailFirst($email_first): self
    {
        $this->email_first = $email_first;

        return $this;
    }

    public function getTableCustomer()
    {
        return $this->tableCustomer;
    }

    public function truncateCustomer()
    {
        try {
            $this->connectDB()
                ->prepare("DELETE FROM " . $this->tableCustomer . " WHERE id>?")
                ->execute(["0"]);
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
}
