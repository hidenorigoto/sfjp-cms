<?php
/**
 * レンダラーの基底クラス
 */
abstract class Renderer {
    /**
     * Constructor
     */
    function __construct()
    {
    }

    abstract public function render($content);
}