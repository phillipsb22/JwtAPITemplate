<?php


namespace App\UserBundle\Fixtures;


use App\UserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('testFixtureUser@mail.com');
        $user->setPassword($this->encoder->encodePassword($user, 't3$tP@ssw0rd'));
        $user->setUuid(Uuid::uuid4());
        $user->setIsActive(true);

        $manager->persist($user);
        $manager->flush();
    }
}