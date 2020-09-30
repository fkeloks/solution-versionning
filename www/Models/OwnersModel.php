<?php


namespace ESGI\Models;

class OwnersModel extends Model
{

    /** @var string[] */
    protected static $searchableColumns = ['lastname', 'firstname', 'mail', 'address', 'phone'];

    /** @var string $lastname */
    protected $lastname;

    /** @var string $firstname */
    protected $firstname;

    /** @var string $mail */
    protected $mail;

    /** @var string $address */
    protected $address;

    /** @var string $phone */
    protected $phone;

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return OwnersModel
     */
    public function setLastName(string $lastname): OwnersModel
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return OwnersModel
     */
    public function setFirstName(string $firstname): OwnersModel
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return OwnersModel
     */
    public function setMail(string $mail): OwnersModel
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return OwnersModel
     */
    public function setAddress(string $address): OwnersModel
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return OwnersModel
     */
    public function setPhone(string $phone): OwnersModel
    {
        $this->phone = $phone;

        return $this;
    }
}
