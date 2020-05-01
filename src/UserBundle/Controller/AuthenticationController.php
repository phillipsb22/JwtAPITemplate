<?php


namespace App\UserBundle\Controller;


use App\UserBundle\Entity\User;
use App\UserBundle\Helper\UserTools;
use App\UtilitiesBundle\ErrorCodes\UserBundleErrorCodes;
use App\UtilitiesBundle\Exception\UserDataException;
use App\UtilitiesBundle\Helper\ApiResponse;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Route("/api/register", name="register", methods={"POST"}, defaults={"_format"="json"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * @throws \Exception
     */
    public function RegisterUserAction (Request $request, UserPasswordEncoderInterface $encoder)
    {
        if (!UserTools::isValidEmailAddress($request->get('username'))) {
            throw new UserDataException('Please use a valid email address as your username', Response::HTTP_BAD_REQUEST, UserBundleErrorCodes::INVALID_EMAIL);
        }

        if (preg_match(self::PASSWORD_REQUIREMENTS, $request->get('password'))) {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(
                [
                    'username' => $request->get('username')
                ]
            );

            if ($user instanceof User) {
                throw new UserDataException(
                    'User already registered, please login or reset your password',
                    Response::HTTP_BAD_REQUEST,
                    Response::HTTP_BAD_REQUEST
                );
            }

            $user = new User();
            $user->setUsername($request->get('username'));
            $user->setPassword($encoder->encodePassword($user, $request->get('password')));
            $user->setUuid(Uuid::uuid4());
            $user->setIsActive(true);
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return new ApiResponse('User successfully registered');
        }

        throw new UserDataException('Complexity of the password is not sufficient, the password must contain: 
            a password length must be greater than or equal to 8, one or more uppercase characters, 
            one or more lowercase characters, one or more numeric values and one or more special characters',
            Response::HTTP_BAD_REQUEST,
            UserBundleErrorCodes::PASSWORD_COMPLEXITY_ERROR
        );
    }

    /**
     * @return ObjectManager
     */
    private function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }
}