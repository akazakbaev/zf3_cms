<?php
/**
 *
 */

namespace Application\Controller\Admin;


use Application\Classes\AdminController;
use Application\Options\LanguageOptions;
use Application\Service\SettingsManager;

use Zf\Infocom\Core\Entity\CoreMailtemplates;

class SettingsController extends AdminController
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * User manager.
     * @var SettingsManager
     */
    private $settingsManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $settingsManager)
    {
        $this->entityManager = $entityManager;
        $this->settingsManager = $settingsManager;
    }

    public function generalAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('settings.general', null)) return;

        $lang = $this->params()->fromQuery('lang', 'ru');
        $prefix = '';

        $languageOptions = $this->getEvent()->getApplication()->getServiceManager()->get(LanguageOptions::class);
        $form = new \Application\Form\Settings\General('general_settings', $prefix, $languageOptions);
        
        $request = $this->getRequest();

        $form->get('language')->setValue($lang);

        if ($request->isPost())
        {
            $post = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);

            if (!$form->isValid($post))
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Invalid data');

                return array(
                    'form' => $form
                );
            }

            $values = $form->getData();

            $lang = $values['language'];

            foreach($values as $key => $value)
            {
                if($key == 'send' || $value == '' || $key == 'language') continue;

                $settingsKey = $lang.'_'.$key;

                $this->settingsManager->setSetting($settingsKey, $value);
            }

            $this->flashMessenger()->setNamespace('success')->addMessage('Changes Saved');

            return array(
                'form' => $form
            );
        }
        else
        {
            foreach ($form->getElements() as $element)
            {
                $name = $element->getName();
                if($name == 'send' || $name == 'language') continue;
                $element->setValue($this->settingsManager->getSetting($lang.'_'.$name));
            }

            return array(
                'form' => $form
            );
        }

    }

    public function mailAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('settings.mail', null)) return;

        // Get mail config
        $mailConfigFile = APPLICATION_PATH . '/config/autoload/mail.local.php';

        $mailConfig = array();
        if( file_exists($mailConfigFile) ) {
            $mailConfig = include $mailConfigFile;
        }

        $form = new \Application\Form\Settings\Mail('mail_settings');

        $request = $this->getRequest();

        if (!$request->isPost())
        {
            foreach ($form->getElements() as $element)
            {
                $element->setValue($this->settingsManager->getSetting($element->getName()));
            }

            return array(
                'form' => $form
            );
        }

        $post = array_merge_recursive(
            $request->getPost()->toArray(), $request->getFiles()->toArray()
        );

        $form->setData($post);

        if (!$form->isValid($post)) {
            $this->flashMessenger()->setNamespace('error')->addMessage('Invalid data');
            return array(
                'form' => $form
            );
        }

        $values = $form->getData();

        foreach($values as $key => $value)
        {
            if($key == 'send' || $value == '') continue;
                $this->settingsManager->setSetting($key, $value);

        }

        // Special case for auth
        if( $values['mail_smtp_send'] )
        {
            // re-assign existing password if form password is left blank
            if( empty($values['mail_smtp_password']) ) {
                if( !empty($mailConfig['mailService']['options']['connection_config']['password']) ){
                    $values['mail_smtp_password'] = $mailConfig['mailService']['options']['connection_config']['password'];
                }
            }
        }


        // Save smtp settings

        $args = array();

        $args['host'] = $values['mail_smtp_host'];
        $args['port'] = (int) $values['mail_smtp_port'];

        if( !empty($values['mail_smtp_ssl']) ) {
            $args['connection_config']['ssl'] = $values['mail_smtp_ssl'];
        }

        if( !empty($values['mail_smtp_authentication']) ) {
            $args['connection_class'] = 'login';

            $args['connection_config']['username'] = $values['mail_smtp_username'];
            $args['connection_config']['password'] = $values['mail_smtp_password'];
        }

        $mailConfig = array(
            'class' => 'Zend\Mail\Transport\Smtp',
            'options_class' => 'Zend\Mail\Transport\SmtpOptions',
            'options' => $args
        );


        // Write contents to file
        if( (is_file($mailConfigFile) && is_writable($mailConfigFile)) ||
            (is_dir(dirname($mailConfigFile)) && is_writable(dirname($mailConfigFile))) ) {
            $contents = "<?php return [ 'mailService' =>
                ";
            $contents .= var_export($mailConfig, true);
            $contents .= "]; ?>";

            file_put_contents($mailConfigFile, $contents);
        } else {
            $this->flashMessenger()->addErrorMessage(
                'Unable to change mail settings due to the file ' .
                '/config/autoload/mail.local.php not having the correct permissions.' .
                'Please CHMOD (change the permissions of) that file to 666, then try again.');
        }


        $this->flashMessenger()->setNamespace('success')->addMessage('Changes Saved');

        return array(
            'form' => $form
        );
    }

    public function templatesAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('settings.templates', null)) return;

        $form = new \Application\Form\Settings\Templates('create');

        $request = $this->getRequest();

        $rows = $this->entityManager->getRepository(CoreMailtemplates::class)->findAll();

        $options = array();

        foreach($rows as $row)
        {
            $options[$row->getId()] = $row->getTitle();
        }

        $form->get('mailtemplate_id')->setValueOptions($options);

        $mailtemplate_id = $this->params()->fromQuery('mailtemplate_id');

        if(!$this->params()->fromQuery('mailtemplate_id'))
        {
            $row =  $this->entityManager->getRepository(CoreMailtemplates::class)->findOneBy([]);
        }
        else
        {
            $row = $this->entityManager->getRepository(CoreMailtemplates::class)->find($this->params()->fromQuery('mailtemplate_id'));
        }

        $form->get('body')->setOption('description', $row->getParams());

        $form->setData(array(
            'mailtemplate_id' => $row->getId(),
            'title' => $row->getTitle(),
            'body' => $row->getBody()
        ));

        if (!$request->isPost())
        {
            return [
                'item' => $row,
                'mailtemplate_id' => $mailtemplate_id,
                'form' => $form,
            ];
        }

        $post = $request->getPost()->toArray();
        $form->setData($post);

        if (!$form->isValid())
        {
            return [
                'item' => $row,
                'mailtemplate_id' => $mailtemplate_id,
                'form' => $form,
            ];
        }

        $values = $form->getData();

        $row->setId($values['mailtemplate_id']);
        $row->setBody($values['body']);
        $row->setTitle($values['title']);

        $this->entityManager->persist($row);

        $this->entityManager->flush();

        return [
            'item' => $row,
            'mailtemplate_id' => $mailtemplate_id,
            'form' => $form,
        ];
    }
}
