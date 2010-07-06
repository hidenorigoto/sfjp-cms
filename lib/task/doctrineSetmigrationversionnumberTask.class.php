<?php
/**
 * doctrineSetmigrationversionnumberTask
 * マイグレーションのバージョン番号を強制的に設定する
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class doctrineSetmigrationversionnumberTask extends sfDoctrineBaseTask {
    /**
     * doctrineSetmigrationversionnumberTask::configure()
     *
     * @return
     */
    protected function configure()
    {
        $this->addArguments(array(new sfCommandArgument('new_version', sfCommandArgument::REQUIRED, 'version number'),
                ));

        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'taskapp'),
                new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
                new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
                ));
        $this->namespace           = 'doctrine';
        $this->name                = 'set-migration-version-number';
        $this->briefDescription    = '';
        $this->detailedDescription = <<<EOF
The [doctrine:set-migration-version-number|INFO] task does things.
Call it with:

  [php symfony doctrine:set-migration-version-number|INFO]
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
        $config  = $this->getCliConfig();
        $migration = new Doctrine_Migration($config['migrations_path']);
        $from    = $migration->getCurrentVersion();
        $new_version = $arguments['new_version'];

        if ($new_version !== $from) {
            $migration->setCurrentVersion($new_version);
        }
        $this->log('Current migration version is ' . $new_version);
    }
}