<?php
/**
 * Shopify
 * @category   Application_Extensions
 * @package    Shopify
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: Truncate.php 08.01.13 10:07 TeaJay $
 * @author     Taalay
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Filter;

class Settings extends AbstractHelper
{
    /**
     * Auth service.
     * @var \Application\Service\SettingsManager
     */
    private $settingsManager;

    public function __construct($settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    public function __invoke()
    {
        return $this->settingsManager;
    }
}