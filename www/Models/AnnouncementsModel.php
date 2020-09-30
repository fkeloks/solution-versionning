<?php

namespace ESGI\Models;

class AnnouncementsModel extends Model
{
    /** @var string[] */
    protected static $searchableColumns = ['description'];

    /** @var string[] */
    public const TYPES = [
        1 => 'Location',
        2 => 'Vente'
    ];

    /** @var string */
    protected $description;

    /** @var int */
    protected $type;

    /** @var float */
    protected $price;

    /** @var string|null $picture */
    protected $picture;

    /** @var int */
    protected $user_id;

    /** @var int */
    protected $status;

    /** @var UsersModel|null */
    protected $user;

    /** @var int */
    protected $batch_id;

    /** @var BatchesModel|null */
    protected $batch;

    /** @var PropertiesModel|null */
    protected $property;

    /** @var string */
    protected $created_at;

    /** @var string */
    protected $updated_at;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return AnnouncementsModel
     */
    public function setDescription(string $description): AnnouncementsModel
    {
        $this->description = $description;

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
     * @return AnnouncementsModel
     */
    public function setType(int $type): AnnouncementsModel
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return number_format($this->price, 2, ',', ' ');
    }

    /**
     * @param float $price
     * @return AnnouncementsModel
     */
    public function setPrice(float $price): AnnouncementsModel
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        // Image par défaut, si aucune image est sélectionnée
        return $this->picture ?: 'https://via.placeholder.com/960x635?text=Aucune+image';
    }

    /**
     * @param string|null $picture
     * @return $this
     */
    public function setPicture(?string $picture): AnnouncementsModel
    {
        $this->picture = $picture;

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
     * @return AnnouncementsModel
     */
    public function setUserId(int $user_id): AnnouncementsModel
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return UsersModel|null
     */
    public function getUser(): ?UsersModel
    {
        if ($this->user instanceof UsersModel) {
            return $this->user;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getBatchId(): int
    {
        return $this->batch_id;
    }

    /**
     * @param int $batch_id
     * @return AnnouncementsModel
     */
    public function setBatchId(int $batch_id): AnnouncementsModel
    {
        $this->batch_id = $batch_id;

        return $this;
    }

    /**
     * @return PropertiesModel|null
     */
    public function getProperty(): ?PropertiesModel
    {
        if ($this->property instanceof PropertiesModel) {
            return $this->property;
        }

        return null;
    }

    /**
     * @return BatchesModel|null
     */
    public function getBatch(): ?BatchesModel
    {
        if ($this->batch instanceof BatchesModel) {
            return $this->batch;
        }

        return null;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return date('d/m/Y H:i', strtotime($this->created_at));
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return date('d/m/Y H:i', strtotime($this->updated_at));
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
     *
     * @return AnnouncementsModel
     */
    public function setStatus(int $status): AnnouncementsModel
    {
        $this->status = $status;

        return $this;
    }
}
