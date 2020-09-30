<?php

namespace ESGI\Models;

use ESGI\Core\Forms\Form;
use ESGI\Core\Forms\Input;
use ESGI\Core\Models\ModelInterface;

class UsersModel extends Model
{
    /** @var string[] */
    protected static $searchableColumns = ['lastname', 'firstname', 'email'];

    /** @var string $firstname */
    protected $firstname;

    /** @var string $lastname */
    protected $lastname;

    /** @var string $email */
    protected $email;

    /** @var string $password */
    protected $password;

    /** @var int|null $group_id */
    protected $group_id;

    /** @var GroupsModel|null $group */
    protected $group;

    /** @var string|null $avatar */
    protected $avatar;

    /** @var string|null $token */
    protected $token;

    /** @var string|null */
    protected $email_confirmation_token;

    /** @var int */
    protected $email_confirmed;

    /** @var int $date_inserted */
    protected $date_inserted;

    /** @var int $date_updated */
    protected $date_updated;

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return UsersModel
     */
    public function setFirstname(string $firstname): UsersModel
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
     * @return UsersModel
     */
    public function setLastname(string $lastname): UsersModel
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UsersModel
     */
    public function setEmail(string $email): UsersModel
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UsersModel
     */
    public function setPassword(string $password): UsersModel
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGroupId(): ?int
    {
        return $this->group_id;
    }

    /**
     * @param int|null $group_id
     *
     * @return UsersModel
     */
    public function setGroupId(?int $group_id): UsersModel
    {
        $this->group_id = $group_id;

        return $this;
    }

    public function getGroup(): ?GroupsModel
    {
        if ($this->group instanceof GroupsModel) {
            return $this->group;
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     *
     * @return UsersModel
     */
    public function setAvatar(?string $avatar): UsersModel
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     *
     * @return UsersModel
     */
    public function setToken(?string $token): UsersModel
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailConfirmationToken(): ?string
    {
        return $this->email_confirmation_token;
    }

    /**
     * @param string|null $email_confirmation_token
     *
     * @return UsersModel
     */
    public function setEmailConfirmationToken(?string $email_confirmation_token): UsersModel
    {
        $this->email_confirmation_token = $email_confirmation_token;

        return $this;
    }

    /**
     * @return int
     */
    public function getEmailConfirmed(): int
    {
        return $this->email_confirmed;
    }

    /**
     * @param int $email_confirmed
     *
     * @return UsersModel
     */
    public function setEmailConfirmed(int $email_confirmed): UsersModel
    {
        $this->email_confirmed = $email_confirmed;

        return $this;
    }

    /**
     * @return int
     */
    public function getDateInserted(): int
    {
        return $this->date_inserted;
    }

    /**
     * @param int $date_inserted
     *
     * @return UsersModel
     */
    public function setDateInserted(int $date_inserted): UsersModel
    {
        $this->date_inserted = $date_inserted;

        return $this;
    }

    /**
     * @return int
     */
    public function getDateUpdated(): int
    {
        return $this->date_updated;
    }

    /**
     * @param int $date_updated
     * @return UsersModel
     */
    public function setDateUpdated(int $date_updated): UsersModel
    {
        $this->date_updated = $date_updated;

        return $this;
    }
}
