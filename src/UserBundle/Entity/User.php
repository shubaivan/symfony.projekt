<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Null;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string")
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string")
     */
    protected $gender;
    /**
     * @ORM\Column(type="string")
     */
    protected $profileAvatar;
    /**
     * @ORM\Column(type="string")
     */
    protected $socialNetworkUrl;
    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    protected $facebookId;
    /**
     * @ORM\Column(type="string")
     */
    protected $facebookAccessToken;

//    /**
//     * @ORM\Column(type="string")
//     */
//    protected $vkontakteId;
//
//    /**
//     * @ORM\Column(type="string")
//     */
//    protected $vkontakteAccessToken;


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set profileAvatar
     *
     * @param string $profileAvatar
     *
     * @return User
     */
    public function setProfileAvatar($profileAvatar)
    {
        $this->profileAvatar = $profileAvatar;

        return $this;
    }

    /**
     * Get profileAvatar
     *
     * @return string
     */
    public function getProfileAvatar()
    {
        return $this->profileAvatar;
    }

    /**
     * Set socialNetworkUrl
     *
     * @param string $socialNetworkUrl
     *
     * @return User
     */
    public function setSocialNetworkUrl($socialNetworkUrl)
    {
        $this->socialNetworkUrl = $socialNetworkUrl;

        return $this;
    }

    /**
     * Get socialNetworkUrl
     *
     * @return string
     */
    public function getSocialNetworkUrl()
    {
        return $this->socialNetworkUrl;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set vkontakteId
     *
     * @param string $vkontakteId
     *
     * @return User
     */
    public function setVkontakteId($vkontakteId)
    {
        $this->vkontakteId = $vkontakteId;

        return $this;
    }

    /**
     * Get vkontakteId
     *
     * @return string
     */
    public function getVkontakteId()
    {
        return $this->vkontakteId;
    }

    /**
     * Set vkontakteAccessToken
     *
     * @param string $vkontakteAccessToken
     *
     * @return User
     */
    public function setVkontakteAccessToken($vkontakteAccessToken)
    {
        $this->vkontakteAccessToken = $vkontakteAccessToken;

        return $this;
    }

    /**
     * Get vkontakteAccessToken
     *
     * @return string
     */
    public function getVkontakteAccessToken()
    {
        return $this->vkontakteAccessToken;
    }
}
