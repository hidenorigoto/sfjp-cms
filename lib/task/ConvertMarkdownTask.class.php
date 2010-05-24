<?php

class ConvertMarkdownTask extends sfBaseTask {
    protected function configure()
    {
        // add your own arguments here
        $this->addArguments(array(
            new sfCommandArgument('file', sfCommandArgument::REQUIRED, 'input file'),
        ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'taskapp'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace           = 'sfjp';
        $this->name                = 'convert-markdown';
        $this->briefDescription    = '';
        $this->detailedDescription = <<<EOF
The [convertMarkdown|INFO] task does things.
Call it with:

  [php symfony convertMarkdown|INFO]
EOF;
    }

    /**
     * ConvertMarkdownTask::execute()
     *
     * @param array $arguments
     * @param array $options
     * @return
     */
    protected function execute($arguments = array(), $options = array())
    {
        // 指定されたファイルを読み込む。
        $file_path = $arguments['file'];
        if (!file_exists($file_path)) {
            $this->log('Can\'t read the specified file.');

            return;
        }

        $contents = file_get_contents($file_path);
        $contents = str_replace("\\n", "\n", $contents);
        echo mySympalMarkdownRenderer::enhanceHtml(
            Markdown($contents), $contents
        );
    }
}