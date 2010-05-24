<?php
/**
 * HtmlRenderer
 * HTML形式をレンダリングするクラス
 */
class HtmlRenderer extends Renderer {
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * HtmlRenderer::render()
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        return $content;
    }
}