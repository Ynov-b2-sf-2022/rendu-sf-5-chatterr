<?php

namespace App\Service;
use App\Repository\UserRepository;


class ExperienceService
{
    public function getExperience(UserRepository $userRepository, string $username): int
    {
        $experience = $userRepository->findOneBy(['username' => $username])->getExperience();

        return $experience;
    }

    public function setExperience(UserRepository $userRepository, string $username, int $experience): void
    {
        $user = $userRepository->findOneBy(['username' => $username]);
        $user->setExperience($experience);
    }

    public function addExperience(UserRepository $userRepository, string $username): void
    {
        $experience = $this->getExperience($userRepository, $username);
        $experience++;
        $this->setExperience($userRepository, $username, $experience);
    }

    public function removeExperience(UserRepository $userRepository, string $username): void
    {
        $experience = $this->getExperience($userRepository, $username);
        $experience--;
        $this->setExperience($userRepository, $username, $experience);
    }
}