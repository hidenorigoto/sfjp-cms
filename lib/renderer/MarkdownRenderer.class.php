<?php
/**
 * MarkdownRenderer
 * markdown形式をレンダリングするクラス
 */
define('MARKDOWN_PARSER_CLASS', 'myMarkdownExtra_Parser');

class MarkdownRenderer extends Renderer {
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * MarkdownRenderer::render()
     *
     * @param mixed $content
     * @return string
     */
    public function render($content)
    {
        $output = mySympalMarkdownRenderer::enhanceHtml(Markdown($content), $content);

        return $output;
    }
}