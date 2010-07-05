<?php

class setFirstCommittedTask extends sfBaseTask
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
    $this->name             = 'set-first-committed';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [setFirstCommitted|INFO] task does things.
Call it with:

  [php symfony setFirstCommitted|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $pages = PageTable::getInstance()->findAll();
      foreach ($pages as $page) {
          $commit = CommitTable::getFirstCommit($page->getId());
          $page->setFirstCommitted($commit->getCommittedAt());

          $page->save();
      }
  }
}
