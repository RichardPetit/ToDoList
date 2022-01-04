<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Task;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;




class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher )
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $task = new Task();

        $user->setUsername("admin")
            ->setEmail("admin@admin.fr")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
            ->setIsVerified(1);
        $manager->persist($user);

        $task->setAuthor(null)
            ->setTitle("Titre de la tâche")
            ->setContent("Contenu de la tâche.")
            ->setIsDone(0)
            ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($task);


        $manager->flush();
    }
}
