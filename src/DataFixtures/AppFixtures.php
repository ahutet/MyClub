<?php

namespace App\DataFixtures;

use App\Entity\Club;
use App\Entity\Player;
use App\Entity\PlayerDetails;
use App\Entity\Season;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadClub($manager);
        $this->loadUser($manager);
        $this->loadSeason($manager);
        $this->loadTeam($manager);
        $this->loadPlayer($manager);
        $this->loadPlayerDetails($manager);

        $manager->flush();
    }

    public function loadClub(ObjectManager $manager)
    {
        $club1 = new Club();
        $club1->setName("Racing Club de Strasbourg");

        $manager->persist($club1);
        $manager->flush();
    }

    public function loadUser(ObjectManager $manager)
    {

        $admin = new User();
        $admin->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname('Admin')
            ->setLastname('ADMIN');
        $password = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($password);
        $manager->persist($admin);

        $coach = new User();
        $coach->setEmail('manager@manager.fr')
            ->setRoles(['ROLE_MANAGER'])
            ->setFirstname('Julien')
            ->setLastname('STEPHAN')
            ->setClub($manager->getRepository(Club::class)->findOneBy(['name' => "Racing Club de Strasbourg"]));
        $password = $this->passwordHasher->hashPassword($coach, 'manager');
        $coach->setPassword($password);
        $manager->persist($coach);

        $manager->flush();
    }

    public function loadSeason(ObjectManager $manager)
    {
        $season1 = new Season();
        $season1->setName("2020-2021")
            ->setDateStart(\DateTime::createFromFormat('d/m/Y', '22/08/2020'))
            ->setDateEnd(\DateTime::createFromFormat('d/m/Y', '23/05/2021'));
        $manager->persist($season1);

        $season2 = new Season();
        $season2->setName("2021-2022")
            ->setDateStart(\DateTime::createFromFormat('d/m/Y', '06/08/2021'))
            ->setDateEnd(\DateTime::createFromFormat('d/m/Y', '21/05/2022'));
        $manager->persist($season2);

        $manager->flush();
    }

    public function loadTeam(ObjectManager $manager)
    {
        $team1 = new Team();
        $team1->setName("Professionnelle")
            ->setDivision('Ligue 1')
            ->setSeason($manager->getRepository(Season::class)->findOneBy(['name' => "2020-2021"]))
            ->setClub($manager->getRepository(Club::class)->findOneBy(['name' => "Racing Club de Strasbourg"]));
        $manager->persist($team1);

        $team2 = new Team();
        $team2->setName("Réserve")
            ->setDivision('CFA')
            ->setSeason($manager->getRepository(Season::class)->findOneBy(['name' => "2020-2021"]))
            ->setClub($manager->getRepository(Club::class)->findOneBy(['name' => "Racing Club de Strasbourg"]));
        $manager->persist($team2);

        $team3 = new Team();
        $team3->setName("Professionnelle")
            ->setDivision('Ligue 1')
            ->setSeason($manager->getRepository(Season::class)->findOneBy(['name' => "2021-2022"]))
            ->setClub($manager->getRepository(Club::class)->findOneBy(['name' => "Racing Club de Strasbourg"]));
        $manager->persist($team3);

        $team4 = new Team();
        $team4->setName("Réserve")
            ->setDivision('CFA')
            ->setSeason($manager->getRepository(Season::class)->findOneBy(['name' => "2021-2022"]))
            ->setClub($manager->getRepository(Club::class)->findOneBy(['name' => "Racing Club de Strasbourg"]));
        $manager->persist($team4);

        $manager->flush();
    }

    public function loadPlayer(ObjectManager $manager)
    {
        $player1 = new Player();
        $player1->setLastname("Ajorque")
            ->setFirstname("Ludovic")
            ->setBirthdate(\DateTime::createFromFormat('d/m/Y', '24/02/1994'))
            ->setEmail("ludovic@ajorque.fr")
            ->addTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2020-2021'])]))
            ->addTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2021-2022'])]));
        $manager->persist($player1);

        $player2 = new Player();
        $player2->setLastname("Gameiro")
            ->setFirstname("Kevin")
            ->setBirthdate(\DateTime::createFromFormat('d/m/Y', '09/05/1987'))
            ->setEmail("kevin@gameiro.fr")
            ->addTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2021-2022'])]));
        $manager->persist($player2);

        $player3 = new Player();
        $player3->setLastname("Sahi")
            ->setFirstname("Moïse")
            ->setBirthdate(\DateTime::createFromFormat('d/m/Y', '20/12/2001'))
            ->setEmail("moïse@sahi.fr")
            ->addTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Réserve", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2020-2021'])]))
            ->addTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2021-2022'])]));
        $manager->persist($player3);

        $player4 = new Player();
        $player4->setLastname("Zohi")
            ->setFirstname("Kevin")
            ->setBirthdate(\DateTime::createFromFormat('d/m/Y', '19/12/1996'))
            ->setEmail("kevin@zohi.fr")
            ->addTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2020-2021'])]));
        $manager->persist($player4);


        $manager->flush();
    }

    public function loadPlayerDetails(ObjectManager $manager)
    {
        $details1 = New PlayerDetails();
        $details1->setTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2020-2021'])]))
            ->setPlayer($manager->getRepository(Player::class)->findOneBy(['lastname' => "Ajorque"]))
            ->setNbGoals(16)
            ->setNbMatch(35)
            ->setNbMinutes(2972)
            ->setNbPass(4);
        $manager->persist($details1);

        $details2 = New PlayerDetails();
        $details2->setTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2021-2022'])]))
            ->setPlayer($manager->getRepository(Player::class)->findOneBy(['lastname' => "Ajorque"]))
            ->setNbGoals(4)
            ->setNbMatch(10)
            ->setNbMinutes(795)
            ->setNbPass(5);
        $manager->persist($details2);

        $details3 = New PlayerDetails();
        $details3->setTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2021-2022'])]))
            ->setPlayer($manager->getRepository(Player::class)->findOneBy(['lastname' => "Gameiro"]))
            ->setNbGoals(3)
            ->setNbMatch(10)
            ->setNbMinutes(684)
            ->setNbPass(0);
        $manager->persist($details3);

        $details4 = New PlayerDetails();
        $details4->setTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Professionnelle", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2020-2021'])]))
            ->setPlayer($manager->getRepository(Player::class)->findOneBy(['lastname' => "Zohi"]))
            ->setNbGoals(2)
            ->setNbMatch(23)
            ->setNbMinutes(434)
            ->setNbPass(0);
        $manager->persist($details4);

        $details5 = New PlayerDetails();
        $details5->setTeam($manager->getRepository(Team::class)->findOneBy(['name' => "Réserve", 'season' => $manager->getRepository(Season::class)->findOneBy(['name' => '2020-2021'])]))
            ->setPlayer($manager->getRepository(Player::class)->findOneBy(['lastname' => "Sahi"]))
            ->setNbGoals(1)
            ->setNbMatch(6)
            ->setNbMinutes(92)
            ->setNbPass(0);
        $manager->persist($details5);

        $manager->flush();
    }
}
