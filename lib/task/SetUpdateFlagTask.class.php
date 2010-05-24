<?php

class SetUpdateFlagTask extends sfBaseTask {
    protected function configure()
    {
        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'taskapp'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));
        $this->namespace           = 'sfjp';
        $this->name                = 'set-update-flag';
        $this->briefDescription    = '';
        $this->detailedDescription = <<<EOF
The [SetUpdateFlag|INFO] task does things.
Call it with:

  [php symfony SetUpdateFlag|INFO]
EOF;
    }

    /**
     * SetUpdateFlagTask::execute()
     *
     * @param array $arguments
     * @param array $options
     * @return
     */
    protected function execute($arguments = array(), $options = array())
    {
        // ログファイルの設定
        $file_logger = new sfFileLogger($this->dispatcher, array(
                'file' => ($this->configuration->getRootDir()
                . '/log/'
                . $this->getName()
                . '.log')
        ));
        $this->dispatcher->connect('application.log', array(
            $file_logger, 'listenToLogEvent'
        ));

        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection      = $databaseManager->getDatabase($options['connection'])->getConnection();

        Doctrine_Query::create()
            ->update('Repository r')
            ->set('r.force_update', '?', 1)
            ->execute();
    }
}