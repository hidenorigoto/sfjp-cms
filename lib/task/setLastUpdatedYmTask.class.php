<?php

class setLastUpdatedYmTask extends sfBaseTask
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

    $this->namespace        = 'sfjp';
    $this->name             = 'set-last-updated-ym';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [setLastUpdatedUM|INFO] task does things.
Call it with:

  [php symfony setLastUpdatedYm|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

      $pages = PageTable::getInstance()->findAll();
      foreach ($pages as $page) {
          $commit = CommitTable::getLatestCommit($page->getId());
          $page->setLastUpdatedYm((int)$commit->getDateTimeObject('committed_at')->format('Ym'));

          $page->save();
      }
  }
}
