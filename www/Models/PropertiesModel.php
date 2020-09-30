<?php

namespace ESGI\Models;

use ESGI\Core\Forms\Form;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class PropertiesModel extends Model
{
    /** @var string[] */
    public const TYPES = [
        1 => 'Maison',
        2 => 'Appartement',
    ];

    /** @var string[] */
    protected static $searchableColumns = ['address'];

    /** @var int $type */
    protected $type;

    /** @var string $address */
    protected $address;

    /** @var string $construction_date */
    protected $construction_date;

    /** @var int $owner_id */
    protected $owner_id;

    /** @var int */
    protected $user_id;

    /** @var UsersModel */
    protected $user;

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return PropertiesModel
     */
    public function setType(int $type): PropertiesModel
    {
        $this->type = $type;

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
     *
     * @return PropertiesModel
     */
    public function setAddress(string $address): PropertiesModel
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getConstructionDate(): string
    {
        return date('d/m/Y', strtotime($this->construction_date));
    }

    /**
     * @param string $construction_date
     *
     * @return PropertiesModel
     */
    public function setConstructionDate(string $construction_date): PropertiesModel
    {
        $this->construction_date = $construction_date;

        return $this;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->owner_id;
    }

    /**
     * @param int $owner_id
     *
     * @return PropertiesModel
     */
    public function setOwnerId(int $owner_id): PropertiesModel
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     *
     * @return PropertiesModel
     */
    public function setUserId(int $user_id): PropertiesModel
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUser(): UsersModel
    {
        return $this->user;
    }
}
