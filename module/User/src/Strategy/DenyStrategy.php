<?php

namespace User\Strategy;


use Zend\Mvc\MvcEvent;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Application;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;


/**
 * Class RedirectStrategy
 * @package CirclicalUser\Strategy
 *
 * Show the user to a login form if the request is not an XHTTP request, and the gate occurs because no user is
 * logged in.  Do not interject if they are logged in, yet don't have necessary rights.
 */
class DenyStrategy implements ListenerAggregateInterface
{
    /**
     * @var string
     */
    protected $template;
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Auth service.
     * @var \User\Service\AuthManager
     */
    private $authManager;

    public function __construct($authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'prepareDenyViewModel'), -5000);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'));
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'prepareDenyViewModel'));
    }
    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }
    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
    /**
     * Callback used when a dispatch error occurs. Modifies the
     * response object with an according error if the application
     * event contains an exception related with authorization.
     *
     * @param MvcEvent $event
     *
     * @return void
     */

    public function prepareDenyViewModel(MvcEvent $e)
    {
        $vars = $e->getResult();


        if ($vars instanceof Response) {
            // Already have a response as the result
            return;
        }

        $response = $e->getResponse();
        $status = $response->getStatusCode();

        if (!in_array($status, array(401, 403)))
        {
            return;
        }

        $mainLayout = $e->getViewModel();



        if(!$this->authManager->getIdentity())
        {
            $mainLayout->setTemplate('layout/login');
        }


        if (! $vars instanceof ViewModel)
        {
            $model = new ViewModel();
            if (is_string($vars)) {
                $model->setVariable('message', $vars);
            } else {
                $model->setVariable('message', 'Page not found.');
            }
        }
        else
        {
            $model = $vars;
            if ($model->getVariable('message') === null) {
                $model->setVariable('message', 'Page not found.');
            }
        }

        $form = new \User\Form\Login();

        $form->get('return_url')->setValue(@$_SERVER['REQUEST_URI']);

        $model->setVariable('form', $form);

        $model->setTemplate('error/'.$status);


        $e->setResult($model);
    }

    public function onDispatchError(MvcEvent $event)
    {return;
        // Do nothing if the result is a response object
        $result = $event->getResult();
        $response = $event->getResponse();
        if ($result instanceof Response || ($response && !$response instanceof HttpResponse)) {
            return;
        }
        // Common view variables
        $viewVariables = array(
            'error' => $event->getParam('error'),
            'identity' => $event->getParam('identity'),
        );
        switch ($event->getError()) {
            case Controller::ERROR:
                $viewVariables['controller'] = $event->getParam('controller');
                $viewVariables['action'] = $event->getParam('action');
                break;
            case Route::ERROR:
                $viewVariables['route'] = $event->getParam('route');
                break;
            case Application::ERROR_EXCEPTION:
                if (!($event->getParam('exception') instanceof UnAuthorizedException)) {
                    return;
                }
                $viewVariables['reason'] = $event->getParam('exception')->getMessage();
                $viewVariables['error'] = 'error-unauthorized';
                break;
            default:
                /*
                 * do nothing if there is no error in the event or the error
                 * does not match one of our predefined errors (we don't want
                 * our 403 template to handle other types of errors)
                 */
                return;
        }
        $model = new ViewModel($viewVariables);
        $response = $response ?: new HttpResponse();
        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $response->setStatusCode(403);
        $event->setResponse($response);
    }
}