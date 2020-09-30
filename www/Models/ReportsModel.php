<?php

namespace ESGI\Models;

class ReportsModel extends Model
{
    /** @var string */
    protected $reason;

    /** @var string */
    protected $client_ip;

    /** @var int */
    protected $announcement_id;

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     * @return ReportsModel
     */
    public function setReason(string $reason): ReportsModel
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return int
     */
    public function getAnnouncementId(): int
    {
        return $this->announcement_id;
    }

    /**
     * @param int $announcementId
     * @return ReportsModel
     */
    public function setAnnouncementId(int $announcementId): ReportsModel
    {
        $this->announcement_id = $announcementId;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientIP(): string
    {
        return $this->client_ip;
    }

    /**
     * @param string $client_ip
     * @return ReportsModel
     */
    public function setClientIP(string $client_ip): ReportsModel
    {
        $this->client_ip = $client_ip;

        return $this;
    }
}
