<?php

namespace Storage\Classes;

use Storage\Exception\VfsException;

class VfsFactory
{
  /**
   * Factory method for VFS
   * 
   * @param string $adapter
   * @param array $config
   * @return Engine_Vfs_Adapter_Interface
   */
  static public function factory($adapter, array $config = array())
  {
    $classPrefix = 'Storage\Adapter';
    if( isset($config['adapterPrefix']) ) {
      $classPrefix = rtrim($config['adapterPrefix'], '_') . ')';
    }

    $class = $classPrefix .'\\'. ucfirst($adapter);

    if( !is_subclass_of($class, 'Storage\Provider\VfsAdapterInterface') ) {
      throw new VfsException('Adapter class must extend Engine_Vfs_Adapter_Interface');
    }

    $instance = new $class($config);

    return $instance;
  }
}
