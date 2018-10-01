<?php
/**
 * @copyright (c) 2017 Core.kg
 * @author Azim Kazakbaev
 * Date: 4/3/17
 */
namespace User\Validator;
use User\Entity\UserUsers;
use Zend\Validator\AbstractValidator;
/**
 * This validator class is designed for checking if there is an existing user
 * with such an email.
 */
class PinExistsValidator extends AbstractValidator
{
    /**
     * Available validator options.
     * @var array
     */
    protected $options = array(
        'entityManager' => null,
        'user' => null,
        'entityClass' => UserUsers::class
    );

    // Validation failure message IDs.
    const NOT_SCALAR  = 'notScalar';
    const USER_EXISTS = 'userExists';

    /**
     * Validation failure messages.
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_SCALAR  => "The pin must be a scalar value",
        self::USER_EXISTS  => "Another user with such an pin already exists"
    );

    /**
     * Constructor.
     */
    public function __construct($options = null)
    {

        // Set filter options (if provided).
        if(is_array($options)) {
            if(isset($options['entityManager']))
                $this->options['entityManager'] = $options['entityManager'];

            if(isset($options['user']))
                $this->options['user'] = $options['user'];
        }

        // Call the parent class constructor
        parent::__construct($options);
    }

    /**
     * Check if user exists.
     */
    public function isValid($value)
    {

        if(!is_scalar($value)) {
            $this->error(self::NOT_SCALAR);
            return false;
        }

        $entityManager = $this->options['entityManager'];

        $user = $entityManager->getRepository($this->options['entityClass'])
            ->findOneByPin($value);


        if($this->options['user']==null)
        {
            $isValid = ($user==null);
        }
        else
        {
            if($this->options['user']->getPin() != $value && $user != null)
                $isValid = false;
            else
                $isValid = true;
        }

        // If there were an error, set error message.
        if(!$isValid) {
            $this->error(self::USER_EXISTS);
        }

        // Return validation result.
        return $isValid;
    }
}