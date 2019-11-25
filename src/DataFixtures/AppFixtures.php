<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Owner;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);
        $manager->flush();

        $region2 = new Region();
        $region2->setCountry("FR");
        $region2->setName("Auvergne-Rhône-Alpes");
        $region2->setPresentation("La capitale des Gaulles");
        $manager->persist($region2);
        $manager->flush();


        $user = new User();
        $user->setEmail("farine@deble.tracteur");
        $user->setRoles(["ROLE_OWNER"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, "password"));

        $owner = new Owner();
        $owner->setFirstname("Jacques");
        $owner->setFamilyName("Boulanger");
        $owner->setAddress("23 Boulevard Chirac 69800 Saint-Priest");
        $owner->setCountry("FR");
        $owner->setUser($user);
        $manager->persist($owner);
        $manager->flush();

        $user2 = new User();
        $user2->setEmail("compote@depomme.pommier");
        $user2->setRoles(["ROLE_OWNER"]);
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, "MotDePasse"));

        $owner2 = new Owner();
        $owner2->setFirstname("Michou");
        $owner2->setFamilyName("Garnier");
        $owner2->setAddress("5 rue Du Grand Château 78646 Versailles");
        $owner2->setCountry("FR");
        $owner2->setUser($user2);
        $manager->persist($owner2);
        $manager->flush();


        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        $room->setCapacity(3);
        $room->setSuperficy(45);
        $room->setPrice(70);
        $room->setAddress("23 Boulevard Bernadette 69800 Saint-Priest");
        $room->addRegion($region);
        $room->setOwner($owner);
        $manager->persist($room);
        $manager->flush();

        $room2 = new Room();
        $room2->setSummary("Grand espace, intéressant pour y inviter sa cour");
        $room2->setDescription("Plutôt grand et luxueux; je conseille tout particulièrement d'aller faire un tour dans la salle des glaces pour y danser un slow endiablé !");
        $room2->setCapacity(467);
        $room2->setSuperficy(67121);
        $room2->setPrice(42000);
        $room2->setAddress("Place d'Armes, 78000 Versailles");
        $room2->addRegion($region);
        $room2->setOwner($owner2);
        $manager->persist($room2);
        $manager->flush();

        $room2 = new Room();
        $room2->setSummary("Conseillé pour les amoureux de la démesure");
        $room2->setDescription("Tout est d'origine et d'époque; particulièrement pratique pour réaliser une petite chasse à cours dans les bois alentours !");
        $room2->setCapacity(236);
        $room2->setSuperficy(52324);
        $room2->setPrice(22300);
        $room2->setAddress("Château, 41250 Chambord");
        $room2->addRegion($region2);
        $room2->setOwner($owner2);
        $manager->persist($room2);
        $manager->flush();

        $user = new User();
        $user->setEmail("gruyere@rape.miam");
        $user->setRoles(["ROLE_CLIENT"]);
        $user->setPassword($this->passwordEncoder->encodePassword($user, "fromage"));

        $client = new Client();
        $client->setFirstname("Mickey");
        $client->setFamilyName("Mouse");
        $client->setCountry("DisneyLand");
        $client->setUser($user);
        $manager->persist($client);
        $manager->flush();
    }
}
