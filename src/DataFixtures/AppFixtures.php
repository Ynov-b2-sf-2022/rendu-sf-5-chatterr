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

        //create grades
        $grades =  ["citoyen", "maire", "président", "dieu"];
        foreach ($grades as $value){
            $grade = new Grade();
            $grade->setName($value);
            $manager->persist($grade);
        }

        //create 10 users
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName)
                ->setPassword($faker->password(8, 20))
                ->setEmail($faker->email)
                ->setRoles(["ROLE_USER"])
                ->setExperience($faker->numberBetween(0, 100))
                ->setGrade($faker->randomElement($grades));
            $users[] = $user;
            $manager->persist($user);
        }

        //create 5 categories
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setName($faker->word)
                ->setUser($faker->randomElement($users));
            $categories[] = $category;
            $manager->persist($category);
        }

        //create 20 messages
        for ($i = 0; $i < 20; $i++) {
            $message = new Message();
            $message->setContent($faker->sentence(15))
                ->setUser($faker->randomElement($users))
                ->setCategory($faker->randomElement($categories));
            $manager->persist($message);
        }
        
        $manager->flush();
    }
}
