<?php
namespace Storage\Adapter;

abstract class AbstractRemote extends AbstractVfsAdapter
{
  protected $_host;

  protected $_port;

  protected $_timeout = 90;

  protected $_username;

  protected $_password;

  public function __destruct()
  {
    $this->disconnect();
  }

  public function __sleep()
  {
    return array_merge(parent::__sleep(), array(
      '_host', '_port', '_timeout', '_useSsl', '_username', '_password'
    ));
  }

  public function getResource()
  {
    if( null === $this->_resource ) {
      $this->connect();
      $this->login();
    }

    return $this->_resource;
  }



  // Config
  
  public function setHost($host)
  {
    if( strpos($host, ':') !== false ) {
      $urlInfo = parse_url($host);
      if( !empty($urlInfo['host']) ) {
        $host = $urlInfo['host'];
      }
      if( !empty($urlInfo['port']) ) {
        $this->setPort($urlInfo['port']);
      }
      if( !empty($urlInfo['user']) ) {
        $this->setUsername($urlInfo['user']);
      }
      if( !empty($urlInfo['pass']) ) {
        $this->setPassword($urlInfo['pass']);
      }
    }
    $this->_host = $host;
    return $this;
  }

  public function getHost()
  {
    return $this->_host;
  }

  public function setPort($port)
  {
    $this->_port = $port;
    return $this;
  }

  public function getPort()
  {
    return $this->_port;
  }

  public function setTimeout($timeout)
  {
    $this->_timeout = (int) $timeout;
    return $this;
  }

  public function getTimeout()
  {
    return $this->_timeout;
  }

  public function setUsername($username)
  {
    $this->_username = $username;
    return $this;
  }

  public function getUsername()
  {
    return $this->_username;
  }

  public function setPassword($password)
  {
    $this->_password = $password;
    return $this;
  }

  public function getPassword()
  {
    return $this->_password;
  }



  // Abstract

  abstract public function connect();

  abstract public function disconnect();

  abstract public function login();
}