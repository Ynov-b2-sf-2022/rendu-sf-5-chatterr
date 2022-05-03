<?php

namespace App\Service;
use App\Repository\UserRepository;
use App\Repository\GradeRepository;


class GradeService
{
    //get the grade
    public function getGrade(UserRepository $userRepository, string $username): int
    {
        $grade = $userRepository->findOneBy(['username' => $username])->getGrade()->getId();
        echo $grade;

        return $grade;
    }

    //set the grade
    public function setGrade(UserRepository $userRepository, GradeRepository $gradeRepository, string $username, int $grade): void
    {
        $grade = $gradeRepository->findOneBy(['id' => $grade]);
        $user = $userRepository->findOneBy(['username' => $username]);
        $user->setGrade($grade);
    }
}