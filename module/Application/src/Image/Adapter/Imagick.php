<?php
/**
 * Azbe Image
 * @copyright (c) 2013, Azbe.net
 * @author Berdimurat Masaliev <muratmbt@gmail.com>
 */

namespace Application\Image\Adapter;

use Application\Image\Image;
use Application\Exception\ImageException;

class Imagick extends Image
{
  /**
   * @var Imagick
   */
  protected $_resource;

  // General
  
  /**
   * Constructor
   *
   * @param string $file Image to open
   */
  public function __construct($options = array())
  {
    // Check support
    if( !class_exists('Imagick', false) ) {
      throw new ImageException('Imagick library is not installed');
    }

    parent::__construct($options);
  }



  // Options

  public function getFile()
  {
    $this->_checkOpenImage();
    return $this->_resource->getImageFilename();
  }

  public function setFile($file)
  {
    $this->_checkOpenImage();
    $this->_resource->setImageFilename($file);
    return $this;
  }

  public function getFormat()
  {
    $this->_checkOpenImage();
    return $this->_resource->getImageFormat();
  }

  public function setFormat($format)
  {
    $this->_checkOpenImage();
    $format = strtoupper($format);
    $this->_resource->setImageFormat($format);
  }

  public function getHeight()
  {
    $this->_checkOpenImage();
    return $this->_resource->getImageHeight();
  }

  public function getWidth()
  {
    $this->_checkOpenImage();
    return $this->_resource->getImageWidth();
  }



  // Actions

  public function create($width, $height, $format = 'png')
  {
    // Destroy first?
    $this->destroy();

    // Create
    $resource = new Imagick();
    $resource->setResolution($width, $height);
    $resource->newImage(100, 100, new ImagickPixel('none'), $format);
    $resource->setImageFormat($format);

    // Save resource
    $this->_resource = $resource;

    return $this;
  }
  
  /**
   * Open an image
   *
   * @param string $file
   * @return Engine_Image_Adapter_Gd
   * @throws \Application\Image\Exception If unable to open
   */
  public function open($file)
  {
    // Destroy first?
    $this->destroy();

    // Open
    $this->_resource = new Imagick();
    $return = $this->_resource->readImage($file);
    if( !$return || !$this->_checkOpenImage(false) ) {
      $this->_resource = null;
      throw new ImageException(sprintf('Unable to open image "%s"', $file));
    }
    return $this;
  }

  /**
   * Write current image to a file
   *
   * @param string $file (OPTIONAL) The file to write to. Default: original file
   * @param string $type (OPTIONAL) The output image type. Default: jpeg
   * @return \Application\Image\Adapter\Gd
   * @throws \Application\Image\Exception If unable to write
   */
  public function write($file = null, $type = 'jpeg')
  {
    $this->_checkOpenImage();

    // Set file type
    if( $type == 'jpg' ) {
      $type = 'jpeg';
    }
    $type = strtoupper($type);
    if( $type !== $this->_resource->getImageFormat() ) {
      $this->_resource->setImageFormat($type);
    }
    // Set quality
    if( null !== $this->_quality ) {
      $this->_resource->setImageCompressionQuality($this->_quality);
    }
    // Write
    if( null === $file ) {
      $return = $this->_resource->writeImage();
    } else {
      $return = $this->_resource->writeImage($file);
    }
    // Error
    if( !$return ) {
      if( !$file ) {
        $file = $this->_resource->getImageFilename();
      }
      throw new ImageException(sprintf('Unable to write image to file "%s"', $file));
    }
    return $this;
  }

  /**
   * Remove the current image object from memory
   */
  public function destroy()
  {
    if( $this->_checkOpenImage(false) ) {
      $this->_resource->destroy();
    }
    $this->_resource = null;
    return $this;
  }

  /**
   * Output an image to buffer or return as string
   *
   * @param string $type Image format
   * @param boolean $buffer Output or return?
   * @return mixed
   * @throws \Application\Image\Exception If unable to output
   */
  public function output($type = 'jpeg', $buffer = false)
  {
    $this->_checkOpenImage();
    
    // Set file type
    if( $type == 'jpg' ) {
      $type = 'jpeg';
    }
    $type = strtoupper($type);
    if( $type !== $this->_resource->getImageFormat() ) {
      $this->_resource->setImageFormat($type);
    }
    // Set quality
    if( null !== $this->_quality ) {
      $this->_resource->setImageCompressionQuality($this->_quality);
    }
    // Output
    if( $buffer ) {
      return (string) $this->_resource;
    } else {
      echo $this->_resource;
    }

    return $this;
  }

  /**
   * Resizes current image to $width and $height. If aspect is set, will fit
   * within boundaries while keeping aspect
   *
   * @param integer $width
   * @param integer $height
   * @param boolean $aspect (OPTIONAL) Default - true
   * @return \Application\Image\Adapter\Gd
   * @throws \Application\Image\Exception If unable to resize
   */
  public function resize($width, $height, $aspect = true)
  {
    $this->_checkOpenImage();

    $imgW = $this->_resource->getImageWidth();
    $imgH = $this->_resource->getImageHeight();
    
    // Keep aspect
    if( $aspect ) {
      list($width, $height) = self::_fitImage($imgW, $imgH, $width, $height);
    }

    // Resize
    try {
      $return = $this->_resource->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
    } catch( \ImagickException $e ) {
      throw new Exception(sprintf('Unable to resize image: %s',
          $e->getMessage()), $e->getCode());
    }
    
    if( !$return ) {
      throw new ImageException('Unable to resize image');
    }
    
    return $this;
  }

  /**
   * Crop an image
   *
   * @param integer $x
   * @param integer $y
   * @param integer $w
   * @param integer $h
   * @return \Application\Image\Adapter\Gd
   * @throws \Application\Image\Exception If unable to crop
   */
  public function crop($x, $y, $w, $h)
  {
    $this->_checkOpenImage();

    // Crop image
    try {
      $return = $this->_resource->cropImage($w, $h, $x, $y);
    } catch( \ImagickException $e ) {
      throw new ImageException(sprintf('Unable to crop image: %s',
          $e->getMessage()), $e->getCode());
    }

    if( !$return ) {
      throw new ImageException('Unable to crop image');
    }

    return $this;
  }

  /**
   * Resample. Just crop+resize
   *
   * @param integer $srcX
   * @param integer $srcY
   * @param integer $srcW
   * @param integer $srcH
   * @param integer $dstW
   * @param integer $dstH
   * @return \Application\Image\Adapter\Gd
   * @throws \Application\Image\Exception If unable to crop
   */
  public function resample($srcX, $srcY, $srcW, $srcH, $dstW, $dstH)
  {
    $this->_checkOpenImage();

    // Resample image

    // Crop
    try {
      $return = $this->_resource->cropImage($srcW, $srcH, $srcX, $srcY);
    } catch( \ImagickException $e ) {
      throw new ImageException(sprintf('Unable to resample image: %s',
          $e->getMessage()), $e->getCode());
    }

    if( !$return ) {
      throw new ImageException('Unable to resample image');
    }

    // Resize
    try {
      $return = $this->_resource->resizeImage($dstW, $dstH, Imagick::FILTER_LANCZOS, 1);
    } catch( \ImagickException $e ) {
      throw new ImageException(sprintf('Unable to resample image: %s',
          $e->getMessage()), $e->getCode());
    }

    if( !$return ) {
      throw new ImageException('Unable to resample image');
    }

    return $this;
  }

  public function rotate($angle)
  {
    // Rotate
    try {
      $return = $this->_resource->rotateImage(new ImagickPixel('none'), $angle);
    } catch( \ImagickException $e ) {
      throw new ImageException(sprintf('Unable to rotate image: %s',
          $e->getMessage()), $e->getCode());
    }
    
    return $this;
  }

  public function flip($horizontal = true)
  {
    // Flip
    try {
      if( $horizontal ) {
        $return = $this->_resource->flopImage();
      } else {
        $return = $this->_resource->flipImage();
      }
    } catch( \ImagickException $e ) {
      throw new ImageException(sprintf('Unable to flip image: %s',
          $e->getMessage()), $e->getCode());
    }

    return $this;
  }



  // Utility

  protected function _checkOpenImage($throw = true)
  {
    if( !($this->_resource instanceof Imagick) ) {
      if( $throw ) {
        throw new ImageException('No open image to operate on.');
      } else {
        return false;
      }
    } else {
      return true;
    }
  }
}