<?php

namespace UserBundle\Providers;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use UserBundle\Entity\User;

class VkontakteProvider
{
    public function setUserData(User $user, UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $responseArray = $response->getResponse();
        var_dump($responseArray);

        $user->setFirstName($responseArray['response'][0]['first_name']);
        $user->setLastName($responseArray['response'][0]['last_name']);
        $user->setEmail('id'.$user->getVkontakteId().'@example.com');
        $user->setGender($responseArray['response'][0]['first_name']);
        $user->setSocialNetworkUrl($responseArray['response'][0]['first_name']);
        $user->setUsername($username);
        $user->setPassword($username);
        $user->setEnabled(true);
        $user->setProfileAvatar($responseArray['response'][0]['photo_50']);

        return $user;
    }
}
