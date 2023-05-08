<?php

namespace App\Entity;

/**
 * Class entity representing one book
 * 
 * @package Book
 * 
 * @var int     $_id
 * @var string  $_title
 * @var string  $_summary
 * @var string  $_content
 * @var int     $_user_id
 */
class Book extends AbstractEntity
{
    /**
     * @var string Book title
     */
    private string $_title;

    /**
     * @var string Book summary
     */
    private string $_summary;

    /**
     * @var string Book content
     */
    private string $_content;

    /**
     * @var int The book author id
     */
    private int $_user_id;

    /**
     * Get the value of _title
     */
    public function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * Set the value of _title
     */
    public function setTitle(string $_title): self
    {
        $this->_title = $_title;

        return $this;
    }

    /**
     * Get the value of _summary
     */
    public function getSummary(): string
    {
        return $this->_summary;
    }

    /**
     * Set the value of _summary
     */
    public function setSummary(string $_summary): self
    {
        $this->_summary = $_summary;

        return $this;
    }

    /**
     * Get the value of _content
     */
    public function getContent(): string
    {
        return $this->_content;
    }

    /**
     * Set the value of _content
     */
    public function setContent(string $_content): self
    {
        $this->_content = $_content;

        return $this;
    }

    /**
     * Get the value of _user_id
     */
    public function getUserId(): int
    {
        return $this->_user_id;
    }

    /**
     * Set the value of _user_id
     */
    public function setUserId(int $_user_id): self
    {
        $this->_user_id = $_user_id;

        return $this;
    }
}