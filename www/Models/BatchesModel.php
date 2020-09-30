<?php

namespace ESGI\Models;

class BatchesModel extends Model
{
    /** @var string[] */
    public const TYPES = [
        1 => 'Maison',
        2 => 'Appartement',
    ];

    /** @var int $number */
    protected $number;

    /** @var int $type */
    protected $type;

    /** @var float $surface */
    protected $surface;

    /** @var int $property_id */
    protected $property_id;

    /** @var PropertiesModel|null $property */
    protected $property;

    /** @var int $owner_id */
    protected $owner_id;

    /** @var int $tenant_id */
    protected $tenant_id;

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return BatchesModel
     */
    public function setNumber(int $number): BatchesModel
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return BatchesModel
     */
    public function setType(int $type): BatchesModel
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurface(): string
    {
        return number_format($this->surface, 2, ',', ' ');
    }

    /**
     * @param float $surface
     * @return BatchesModel
     */
    public function setSurface(float $surface): BatchesModel
    {
        $this->surface = $surface;

        return $this;
    }

    /**
     * @return int
     */
    public function getPropertyId(): int
    {
        return $this->property_id;
    }

    /**
     * @param int $property_id
     * @return BatchesModel
     */
    public function setPropertyId(int $property_id): BatchesModel
    {
        $this->property_id = $property_id;

        return $this;
    }

    public function getProperty(): ?PropertiesModel
    {
        if ($this->property instanceof PropertiesModel) {
            return $this->property;
        }

        return null;
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
     * @return BatchesModel
     */
    public function setOwnerId(int $owner_id): BatchesModel
    {
        $this->owner_id = $owner_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getTenantId(): int
    {
        return $this->tenant_id;
    }

    /**
     * @param int $tenant_id
     * @return BatchesModel
     */
    public function setTenantId(int $tenant_id): BatchesModel
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }
}
