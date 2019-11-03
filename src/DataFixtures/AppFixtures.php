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

    // définit un nom de référence pour une instance de Region
    public const IDF_REGION_REFERENCE = 'idf-region';

    public function load(ObjectManager $manager)
    {
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);
        $manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);


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


        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        $room->setCapacity(3);
        $room->setSuperficy(45);
        $room->setPrice(70);
        $room->setAddress("23 Boulevard Bernadette 69800 Saint-Priest");
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $room->setOwner($owner);
        $manager->persist($room);
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
