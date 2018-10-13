<?php
namespace Storage\Provider;

interface VfsAdapterInterface
{
  const SYS_LIN = 'linux';
  const SYS_UNI = 'unix';
  const SYS_WIN = 'windows';
  const SYS_DAR = 'darwin';
  const SYS_BSD = 'bsd';


  
  // General
  
  public function __construct(array $config = null);

  public function getAdapterPrefix();

  public function getAdapterType();

  public function getResource();

  public function getDirectorySeparator();

  public function getUmask($withPermission = null);



  // Informational

  public function exists($path);

  public function isDirectory($path);

  public function isFile($path);

  public function path($path = '');

  public function getSystemType();

  public function stat($path);



  // Factory

  public function directory($path = '');

  public function info($path = '');

  public function object($path, $mode = 'r');



  // General

  public function copy($sourcePath, $destPath);

  public function get($local, $path);

  public function getContents($path);

  public function mode($path, $mode, $recursive = false);

  public function move($oldPath, $newPath);

  public function put($path, $local);

  public function putContents($path, $data);

  public function unlink($path);



  // Directories

  public function changeDirectory($directory);

  public function listDirectory($directory, $details = false);

  public function makeDirectory($directory, $recursive = false);

  public function printDirectory();

  public function removeDirectory($directory, $recursive = false);



  // User

  public function getUid();

  public function getGid();
}