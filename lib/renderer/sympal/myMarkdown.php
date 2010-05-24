<?php
/**
 * myMarkdownExtra_Parser
 *
 * @package
 * @author goto
 * @copyright Copyright (c) 2010
 * @version $Id$
 * @access public
 */
class myMarkdownExtra_Parser extends MarkdownExtra_Parser {
    /**
     * myMarkdownExtra_Parser::_doHeaders_callback_setext()
     * 見出しタグにidを自動付与するように変更
     *
     * @param mixed $matches
     * @return
     */
    function _doHeaders_callback_setext($matches)
    {
        $level = ($matches[3]{0} == '=') ? 1 : 2;
        $id    = sprintf(' id="%s"', md5($matches[1]));
        $block = "<h$level$id>"
               . $this->runSpanGamut($matches[1])
               . "</h$level>";

        return "\n" . $this->hashBlock($block) . "\n\n";
    }

    /**
     * myMarkdownExtra_Parser::_doHeaders_callback_atx()
     * 見出しタグにidを自動付与するように変更
     *
     * @param mixed $matches
     * @return
     */
    function _doHeaders_callback_atx($matches)
    {
        $level = strlen($matches[1]);
        $id    = sprintf(' id="%s"', md5($matches[2]));
        $block = "<h$level$id>"
               . $this->runSpanGamut($matches[2])
               . "</h$level>";

        return "\n" . $this->hashBlock($block) . "\n\n";
    }
}