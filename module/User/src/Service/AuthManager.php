<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/5/18
 * Time: 4:32 PM
 */
namespace User\Service;

use User\Entity\UserUsers;
use Zend\Authentication\Result;
use Zend\Session\Container;

class AuthManager
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * Session manager.
     * @var \Zend\Session\SessionManager
     */
    private $sessionManager;

    /**
     * Contents of the 'access_filter' config key.
     * @var array
     */
    private $config;

    /**
     * UserUser.
     * @var \User\Entity\UserUsers
     */
    private $viewer = null;


    /**
     * Constructs the service.
     */
    public function __construct($authService, $entityManager, $sessionManager, $config)
    {
        $this->authService = $authService;
        $this->entityManager = $entityManager;
        $this->sessionManager = $sessionManager;
        $this->config = $config;
    }

    /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     */
    public function login($identity, $password, $rememberMe)
    {
        // Check if user has already logged in. If so, do not allow to log in
        // twice.
        if ($this->authService->getIdentity() != null)
        {
            throw new \Exception('Already logged in');
        }


        // Authenticate with login/password.
        $this->authService->getAdapter()
                        ->setUsername($identity)
                        ->setCredential($password);

        $result = $this->authService->authenticate();

        if ($result->getCode() == Result::SUCCESS)
        {
            // If user wants to "remember him", we will make session to expire in
            // one month. By default session expires in 1 hour (as specified in our
            // config/global.php file).

            if($rememberMe)
            {
                // Session cookie will expire in 1 month (30 days).
                $this->sessionManager->rememberMe(60*60*24*30);
            }

            $this->loginLog($this->authService->getIdentity(), $identity, Result::SUCCESS);
        }
        else
        {
            $this->loginLog($this->authService->getIdentity(), $identity, $result->getCode());
        }

        if($this->authService->getIdentity())
        {
            $session = new Container('Zend_Auth');
            $session->identity = $this->authService->getIdentity();
            $session->start = time();

        }

        return $result;
    }

    /**
     * Performs user logout.
     */
    public function logout()
    {
        // Allow to log out only when user is logged in.
        if ($this->authService->getIdentity()==null) {
            throw new \Exception('The user is not logged in');
        }

        // Remove identity from session.
        $this->authService->clearIdentity();
    }

    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }

    public function getViewer()
    {
        if (is_null($this->viewer))
        {
            $id = $this->authService->getIdentity();

            if($id == null) $id = 0;

            $viewer = $this->entityManager->getRepository(UserUsers::class)->find($id);

            if($viewer === null) $viewer = new \User\Entity\UserUsers();

            $this->setViewer($viewer);
        }

        return $this->viewer;
    }

    public function setViewer($viewer)
    {
        $this->viewer = $viewer;
    }

    public function loginOauth($user)
    {
        $this->authService->getStorage()->write($user->getId());

        $this->loginLog($user->getId(), $user->getUsername(), Result::SUCCESS);

        return new Result(
            Result::SUCCESS,
            $user->getId(),
            ['Authenticated successfully.']);
    }

    public function loginLog($user_id = null, $username = '', $status = -1)
    {

        $remoteAddress = new \Zend\Http\PhpEnvironment\RemoteAddress();

        $ip = '127.0.0.0';

        if ('cli' !== PHP_SAPI)
        {
            $ip = $remoteAddress->getIpAddress();
        }


        $conn = $this->entityManager->getConnection();
        $conn->beginTransaction();
        try{

            $login = new \User\Entity\UserLogins();

            $login->setUserId($user_id);
            $login->setUsername($username);
            $login->setCreationDate( new \DateTime());
            $login->setIp($ip);
            $login->setStatus($status);

            $this->entityManager->persist($login);

            // Apply changes to database.
            $this->entityManager->flush();


            $this->entityManager->getConnection()->commit();
        }catch(\Exception $e){
            $this->logout();

            $this->entityManager->getConnection()->rollBack();

            var_dump($e->getMessage());die;
        }
    }

    public function getVerifyToken($userId)
    {
        return base64_encode(time() . ":" . $userId);
    }

    public function getUserIdFromToken($token)
    {
        $decodedToken = base64_decode($token);
        $decodedToken = explode(':', $decodedToken);
        $userId = $decodedToken[1];
        return $userId;
    }
}