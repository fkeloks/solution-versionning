<?php


namespace ESGI\Models;

use ESGI\Core\Forms\Form;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class StaffModel extends Model
{
    /** @var string[] */
    protected static $searchableColumns = ['firstname', 'lastname', 'function'];

    /** @var string $firstname */
    protected $firstname;

    /** @var string $lastname */
    protected $lastname;

    /** @var string $function */
    protected $function;

    /** @var float $salary */
    protected $salary;

    /** @var int $status */
    protected $status;


    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return StaffModel
     */
    public function setFirstname(string $firstname): StaffModel
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return StaffModel
     */
    public function setLastname(string $lastname): StaffModel
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getFunction(): string
    {
        return $this->function;
    }


    /**
     * @param string $function
     * @return StaffModel
     */
    public function setFunction(string $function): StaffModel
    {
        $this->function = $function;

        return $this;
    }

    /**
     * @return float
     */
    public function getSalary(): float
    {
        return $this->salary;
    }

    /**
     * @param float $salary
     * @return StaffModel
     */
    public function setSalary(float $salary): StaffModel
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return StaffModel
     */
    public function setStatus(int $status): StaffModel
    {
        $this->status = $status;

        return $this;
    }
}
