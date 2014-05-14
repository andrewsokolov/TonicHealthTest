<?php

namespace Auth\AuthBundle\Entity;

/**
 * UserReferal
 */
class UserReferal
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $referal;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $referer;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $users;

     public function __construct(){
         $this->users   = new \Doctrine\Common\Collections\ArrayCollection();
     }

    /**
     * Add users
     *
     * @param \Auth\AuthBundle\Entity\User $user
     * @return UserReferal
     */
    public function addUserReferal(\Auth\AuthBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Auth\AuthBundle\Entity\User $user
     */
    public function removeUserReferal(\Auth\AuthBundle\Entity\User $user
    ) {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $referal
     */
    public function setReferal($referal)
    {
        $this->referal = $referal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferal()
    {
        return $this->referal;
    }

    /**
     * @param mixed $referer
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReferer()
    {
        return $this->referer;
    }


}