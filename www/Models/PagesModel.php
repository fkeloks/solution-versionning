<?php

namespace ESGI\Models;

class PagesModel extends Model
{
    /** @var string[] */
    protected static $searchableColumns = ['title'];

    public const STATUS_HIDDEN = 0;
    public const STATUS_PUBLISHED = 1;
    public const STATUS_DRAFT = 2;

    /** @var string $title */
    protected $title;

    /** @var string $path */
    protected $path;

    /** @var int $status */
    protected $status;

    /** @var string|null $description */
    protected $description;

    /** @var string $updated_at */
    protected $updated_at;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return PagesModel
     */
    public function setTitle(string $title): PagesModel
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return PagesModel
     */
    public function setPath(string $path): PagesModel
    {
        $this->path = $path;

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
     *
     * @return PagesModel
     */
    public function setStatus(int $status): PagesModel
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return PagesModel
     */
    public function setDescription(?string $description): PagesModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     */
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
