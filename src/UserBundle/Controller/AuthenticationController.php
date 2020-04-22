<?php


namespace App\UserBundle\Controller;


use App\UserBundle\Entity\User;
use App\UserBundle\Helper\UserTools;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Uuid;

class AuthenticationController extends AbstractController
{
    /*
     * The password length must be greater than or equal to 8
     * The password must contain one or more uppercase characters
     * The password must contain one or more lowercase characters
     * The password must contain one or more numeric values
     * The password must contain one or more special characters
     */
    const PASSWORD_REQUIREMENTS = '/(?=^.{8,}$)(?=.*\d)(?=.*[!@#$%^&*]+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/';

    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * @throws \Exception
     */
    public function RegisterUserAction (Request $request, UserPasswordEncoderInterface $encoder)
    {
        if (UserTools::isValidEmailAddress($request->get('username'))) {
            throw new \Exception('Please use a valid email address as your username');
        }

        if (preg_match(self::PASSWORD_REQUIREMENTS, $request->get('password'))) {
            // check if the username already exitsts
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(
                [
                    'username' => $request->get('username')
                ]
            );

            if ($user instanceof User) {
                // Change this to say something else for security purposes
                // Facebook sends a password change pin to reset password
                throw new \Exception('Please login');
            }

            $user = new User();
            $user->setUsername($request->get('username'));
            $user->setPassword($encoder->encodePassword($user, $request->get('password')));
            $user->setUuid(Uuid::uuid4());
            $user->setIsActive(true);
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return new JsonResponse('User successfully registered', Response::HTTP_OK);
        }

        throw new \Exception('Complexity of the password is not sufficient');
    }

    /**
     * @return ObjectManager
     */
    private function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }
}