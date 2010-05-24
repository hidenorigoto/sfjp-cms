<?php
class mySympalMarkdownRenderer extends sfSympalMarkdownRenderer {
    /**
     * mySympalMarkdownRenderer::enhanceHtml()
     *
     * @param mixed $html
     * @param mixed $markdown
     * @return
     */
    public static function enhanceHtml($html, $markdown)
    {
        $boxes = array('quote', 'tip', 'caution', 'note');
        $boxes = implode('|', $boxes);
        $html  = preg_replace('#<blockquote>\s*<p><strong>('.$boxes.')</strong>\:?#sie','\'<blockquote class="\'.strtolower("$1").\'"><p>\'', $html);

        // Sidebar
        $html  = preg_replace('#<blockquote>\s*<p><strong>sidebar</strong>\s*(.+?)\s*</p>#si', '<blockquote class="sidebar"><p class="title">$1</p>', $html);

        // Fix spacer
        $html  = str_replace('<p>-</p>', '', $html);

        // SQL
        $html  = preg_replace_callback('#<pre><code>(alter|create|drop|select|update|delete|from|group by|having|where)(.+?)</code></pre>#si', array('sfSympalMarkdownRenderer', 'highlightSql'), $html);

        // Yaml
        $html  = preg_replace_callback('#<pre><code>(.+?)</code></pre>#s', array('sfSympalMarkdownRenderer', 'highlightYaml'), $html);

        // Syntax highlighting
        $html  = preg_replace_callback('#<pre><code>(.+?)</code></pre>#s', array('mySympalMarkdownRenderer', 'highlightPhp'), $html);

        return $html;
    }

    /**
     * mySympalMarkdownRenderer::highlightPhp()
     *
     * @param mixed $matches
     * @return
     */
    public static function highlightPhp($matches)
    {
        return self::geshiCall($matches);
    }

    /**
     * mySympalMarkdownRenderer::geshiCall()
     *
     * @param mixed $matches
     * @param string $default
     * @return
     */
    static protected function geshiCall($matches, $default = '')
    {
        if (preg_match('/^\[(.+?)\]\s*(.+)$/s', $matches[1], $match)) {
            if ($match[1] == 'sql') {
                return "<pre><code class=\"sql\">"
                    . self::highlightSql(array(html_entity_decode($match[2])))
                    . '</code></pre>';
            } else if ($match[1] == 'yaml' || $match[1] == 'yml') {
                return self::highlightYaml($match[2]);
            } else if ($match[1] == 'php') {
                $code = html_entity_decode($match[2]);
                return self::getGeshi($code, 'php');
            } else {
                return self::getGeshi(html_entity_decode($match[2]), $match[1]);
            }
        } else {
            if ($default) {
                return self::getGeshi(html_entity_decode($matches[1]), $default);
            }else {
                return "<pre><code>" . $matches[1] . '</code></pre>';
            }
        }
    }
}