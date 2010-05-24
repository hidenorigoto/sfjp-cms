<?php
/**
 * myVersionControl_Git_Util_RevListFetcher
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class myVersionControl_Git_Util_RevListFetcher extends VersionControl_Git_Util_RevListFetcher {
    /**
     * The filter
     *
     * @var string
     */
    protected $filter = '';

    /**
     * myVersionControl_Git_Util_RevListFetcher::setFilter()
     *
     * @param mixed $filter
     * @return
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * myVersionControl_Git_Util_RevListFetcher::fetch()
     *
     * @return
     */
    public function fetch()
    {
        $string = $this->setSubCommand('rev-list')
                ->setOption('pretty', 'raw')->addArgument($this->target)->execute();
        $lines  = explode("\n", $string);

        $this->reset();
        $commits = array();
        while (count($lines)) {
            $commit  = array_shift($lines);
             if (!$commit) {
                continue;
            }

            $tree = array_shift($lines);
            $parents = array();
            while (count($lines) && 0 === strpos($lines[0], 'parent')) {
                $parents[] = array_shift($lines);
            }

            $author    = array_shift($lines);
            $committer = array_shift($lines);
            $message   = array();
            array_shift($lines);
            while (count($lines) && 0 === strpos($lines[0], '   ')) {
                $message[] = trim(array_shift($lines));
            }

            array_shift($lines);
            $commits[] = myVersionControl_Git_Object_Commit::createInstanceByArray($this->git, array(
                'commit'    => $commit,
                'tree'      => $tree,
                'parents'   => $parents,
                'author'    => $author,
                'committer' => $committer,
                'message'   => implode("\n", $message),
            ));
        }

        return $commits;
    }

    /**
     * myVersionControl_Git_Util_RevListFetcher::createCommandString()
     *
     * @param array $arguments
     * @param array $options
     * @return
     */
    protected function createCommandString($arguments   = array(), $options = array())
    {
        if (!$this->subCommand) {
            throw new VersionControl_Git_Exception('You must specify "subCommand"');
        }
        $command   = $this->git->getGitCommandPath().' '.$this->subCommand;
        $arguments = array_merge($this->arguments, $arguments);
        $options   = array_merge($this->options, $options);

        foreach ($options as $k => $v) {
            if (false === $v) {
                continue;
            }

            if (1 === strlen($k)) {
                $command .= ' -' . $k;
            } else {
                $command .= ' --' . $k;
            }

            if (true !== $v) {
                $command .= '=' . escapeshellarg($v);
            }
        }

        foreach ($arguments as $v) {
            $command .= ' ' . escapeshellarg($v);
        }

        if ($this->doubleDash) {
            $command .= ' --';
        }

        if ($this->filter) {
            $command .= ' ' . $this->filter;
        }

        return $command;
    }
}