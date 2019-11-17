<?php
/**
 * Created by JetBrains PhpStorm.
 * User: azim
 * Date: 9/13/13
 * Time: 10:31 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\View\Helper;


use Storage\Service\FileManager;

use Zend\View\Helper\AbstractHelper;

class ItemPhoto extends AbstractHelper
{
    /**
     * @var FileManager
     */
    protected $fileManager;


    public function __construct($fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function __invoke($file_id, $type = 'thumb.normal', $alt = "", $attribs = array())
    {
        if( null == $file_id )
        {
            return $this->getNoPhoto($file_id, $alt, $attribs);
        }

        if(is_object($file_id))
            $file_id = $file_id->getId();

        $src = $this->fileManager->getPhotoUrl($file_id, $type);

        if(!$src)
        {
            return $this->getNoPhoto($type, $alt, $attribs);
        }

        return $this->getView()->htmlImage($src, $alt, $attribs);
    }


    public function getNoPhoto($type = 'thumb.normal', $alt = "", $attribs = [])
    {
        $type = ( $type ? str_replace('.', '_', $type) : 'main' );

        $attribs['class'] = isset($attribs['class']) ? $attribs['class'] : ' ';
        $attribs['class'] .= ' no_photo';

        return $this->getView()->htmlImage('/images/nophoto_profile_user.png', 'no_photo', $attribs);
    }
}