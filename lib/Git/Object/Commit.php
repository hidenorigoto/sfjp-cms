<?php
/**
 * myVersionControl_Git_Object_Commit
 *
 * @package sfjp
 * @author hidenorigoto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class myVersionControl_Git_Object_Commit extends VersionControl_Git_Object_Commit {
    protected $parsed_author    = null;
    protected $parsed_committer = null;

    /**
     * myVersionControl_Git_Object_Commit::createInstanceByArray()
     *
     * @param mixed $git
     * @param mixed $array
     * @return
     */
    public static function createInstanceByArray($git, $array)
    {
        if (!isset($array['commit']) || !$array['commit']) {
            throw new VersionControl_Git_Exception('The commit object must have id');
        }
        $parts = explode(' ', $array['commit'], 2);
        $id    = $parts[1];

        unset($array['commit']);
        $obj = new myVersionControl_Git_Object_Commit($git, $id);

        foreach ($array as $k => $v) {
            $method = 'set'.ucfirst($k);

            if (is_callable(array($obj, $method))) {
                $obj->$method($v);
            }
        }

        return $obj;
    }

    /**
     * myVersionControl_Git_Object_Commit::getAuthorEmail()
     *
     * @return
     */
    public function getAuthorEmail()
    {
        if (!$this->parsed_author) {
            $this->parsed_author = self::parseAddress($this->getAuthor());
        }

        return sprintf('%s@%s', $this->parsed_author->mailbox, $this->parsed_author->host);
    }

    /**
     * myVersionControl_Git_Object_Commit::getAuthorHandle()
     *
     * @return
     */
    public function getAuthorHandle()
    {
        if (!$this->parsed_author) {
            $this->parsed_author = self::parseAddress($this->getAuthor());
        }

        return $this->parsed_author->personal;
    }

    /**
     * myVersionControl_Git_Object_Commit::getCommitterEmail()
     *
     * @return
     */
    public function getCommitterEmail()
    {
        if (!$this->parsed_committer) {
            $this->parsed_committer = self::parseAddress($this->getCommitter());
        }

        return sprintf('%s@%s', $this->parsed_committer->mailbox, $this->parsed_committer->host);
    }

    /**
     * myVersionControl_Git_Object_Commit::getCommitterHandle()
     *
     * @return
     */
    public function getCommitterHandle()
    {
        if (!$this->parsed_committer) {
            $this->parsed_committer = self::parseAddress($this->getCommitter());
        }

        return $this->parsed_committer->personal;
    }

    /**
     * myVersionControl_Git_Object_Commit::getCommittedDateTime()
     *
     * @return
     */
    public function getCommittedDateTime()
    {
        $datetime = new DateTime();
        $datetime->setTimestamp($this->getCommittedAt());

        return $datetime;
    }

    /**
     * myVersionControl_Git_Object_Commit::parseAddress()
     *
     * @param mixed $data
     * @return string
     */
    protected static function parseAddress($data)
    {
        $rfc822 = new Mail_RFC822();
        $parsed = $rfc822->parseAddressList($data);

        //  戻り値が配列ではない場合は、エラーなので空を返す。
        if (is_array($parsed)) {
            return $parsed[0];
        } else {
            return '';
        }
    }
}