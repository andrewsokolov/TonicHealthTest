<?php
// src/Auth/AuthBundle/Entity/User.php

namespace Auth\AuthBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var string
     */
    protected $referal;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $user_referals;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->user_referals = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add user_referals
     *
     * @param \Auth\AuthBundle\Entity\UserReferal $userReferal
     * @return User
     */
    public function addUserReferal(\Auth\AuthBundle\Entity\UserReferal $userReferal)
    {
        $this->user_referals[] = $userReferal;

        return $this;
    }

    /**
     * Remove user_referals
     *
     * @param \Auth\AuthBundle\Entity\UserReferal $userReferal
     */
    public function removeUserReferal(
        \Auth\AuthBundle\Entity\UserReferal $userReferal
    ) {
        $this->user_referals->removeElement($userReferal);
    }

    /**
     * Get user_referals
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserReferals()
    {
        return $this->user_referals;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $referal
     */
    public function setReferal($referal)
    {
        $this->referal = $referal;
        return $this;
    }

    /**
     * @return string
     */
    public function getReferal()
    {
        return $this->referal;
    }

    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);
    }
}