<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Grade;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //import faker
        $faker = \Faker\Factory::create('fr_FR');

        //create 5 grades
        $grades = [];
        for ($i = 0; $i < 3; $i++) {
            $grade = new Grade();
            $grade->setName($faker->name);
            $manager->persist($grade);
            $grades[] = $grade;
        }

        //create 5 users
        $users = [];
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername($faker->userName)
                ->setPassword($faker->password(8, 20))
                ->setEmail($faker->email)
                ->setExperience($faker->numberBetween(0, 100))
                ->setGrade($faker->randomElement($grades));
            $users[] = $user;
            $manager->persist($user);
        }

        //create 5 categories
        $categories = [];
        for ($i = 0; $i < 3; $i++) {
            $category = new Category();
            $category->setName($faker->name)
                ->setUser($faker->randomElement($users));
            $categories[] = $category;
            $manager->persist($category);
        }

        //create 5 messages
        for ($i = 0; $i < 15; $i++) {
            $message = new Message();
            $message->setContent($faker->text)
                ->setUser($faker->randomElement($users))
                ->setCategory($faker->randomElement($categories));
            $manager->persist($message);
        }

        $manager->flush();

    }
}
