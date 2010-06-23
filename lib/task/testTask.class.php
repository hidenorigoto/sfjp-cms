<?php

class testTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'taskapp'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'test';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [test|INFO] task does things.
Call it with:

  [php symfony test|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
      $frontend_cache_dir = sfConfig::get('sf_cache_dir') . '/frontend/prod/template';
      $cache = new sfFileCache(array('cache_dir' => $frontend_cache_dir));
      $cache->clean();
  }
}