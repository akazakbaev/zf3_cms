<?php
namespace Storage\Provider;

interface SchemeInterface
{
  public function generate(array $params);
}