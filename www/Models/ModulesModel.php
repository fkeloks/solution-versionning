<?php

namespace ESGI\Models;

use ESGI\Core\Configuration\Config;
use Exception;

class ModulesModel extends Model
{
    /** @var int $page_id */
    protected $page_id;

    /** @var string $name */
    protected $name;

    /** @var integer $order */
    protected $order;

    /** @var array|string $content */
    protected $content;

    /**
     * @return int
     */
    public function getPageId(): int
    {
        return $this->page_id;
    }

    /**
     * @param int $page_id
     *
     * @return ModulesModel
     */
    public function setPageId(int $page_id): ModulesModel
    {
        $this->page_id = $page_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ModulesModel
     */
    public function setName(string $name): ModulesModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @param int $order
     *
     * @return ModulesModel
     */
    public function setOrder(int $order): ModulesModel
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        try {
            if (!is_string($this->content)) {
                return [];
            }

            return json_decode($this->content, true);
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * @param string|array $content
     *
     * @return ModulesModel
     */
    public function setContent($content): ModulesModel
    {
        if (is_string($content)) {
            $this->content = $content;
        } else {
            $content = json_encode($content);
            if (is_string($content)) {
                $this->content = $content;
            }
        }

        return $this;
    }

    public function getConfiguration(): array
    {
        $modules = Config::get('modules', []);
        foreach ($modules as $name => $module) {
            if ($name === $this->getName()) {
                return $module;
            }
        }

        return [];
    }
}
