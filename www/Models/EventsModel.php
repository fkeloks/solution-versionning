<?php

namespace ESGI\Models;

class EventsModel extends Model
{
    /** @var string[] */
    protected static $searchableColumns = ['name'];

    /** @var string $name */
    protected $name;

    /** @var int $type */
    protected $type;

    /** @var string $date_start */
    protected $date_start;

    /** @var string $date_end */
    protected $date_end;

    /** @var string $time_start */
    protected $time_start;

    /** @var string $time_end */
    protected $time_end;

    /** @var int|null user_id */
    protected $user_id;

    /** @var StaffModel|null $staff */
    protected $staff;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EventsModel
     */
    public function setName(string $name): EventsModel
    {
        $this->name = $name;

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
     * @return EventsModel
     */
    public function setType(int $type): EventsModel
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateStart(): string
    {
        return date('d/m/Y', strtotime($this->date_start));
    }

    /**
     * @param string $date_start
     * @return EventsModel
     */
    public function setDateStart(string $date_start): EventsModel
    {
        $this->date_start = $date_start;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return date('d/m/Y', strtotime($this->date_end));
    }

    /**
     * @param string $date_end
     * @return EventsModel
     */
    public function setDateEnd(string $date_end): EventsModel
    {
        $this->date_end = $date_end;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeStart(): string
    {
        return date('H:i', strtotime($this->time_start));
    }

    /**
     * @param string $time_start
     * @return EventsModel
     */
    public function setTimeStart(string $time_start): EventsModel
    {
        $this->time_start = $time_start;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeEnd(): string
    {
        return date('H:i', strtotime($this->time_end));
    }

    /**
     * @param string $time_end
     * @return EventsModel
     */
    public function setTimeEnd(string $time_end): EventsModel
    {
        $this->time_end = $time_end;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     * @return EventsModel
     */
    public function setUserId(?int $user_id): EventsModel
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStaff(): ?StaffModel
    {
        if ($this->staff instanceof StaffModel) {
            return $this->staff;
        }

        return null;
    }
}
