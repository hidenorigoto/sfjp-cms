<?php
/**
 * link_to_option_selectable()
 * 動的な条件判断をclosureで指定して、条件の結果に基づいてオプションを設定するlink_to
 *
 * @param  string  $text             リンクを設定する文字列
 * @param  string  $path             リンク先ページのパス
 * @param  closure $compare_function 条件判断関数（true/falseを返す）
 * @param  mixed   $default_options  条件に関わらず設定するオプション
 * @param  mixed   $true_options     条件が成立した場合に設定するオプション
 * @param  mixed   $false_options    条件が成立しない場合に設定するオプション
 * @return string  リンクタグ
 */
function link_to_option_selectable($text, $path,
    $compare_function  = null,
    $default_options   = null,
    $true_options      = null,
    $false_options     = null)
{
    // オプションが何も指定されていない場合、自動でtitle属性を設定する
    if (!is_array($default_options) || !count($default_options)) {
        $default_options = array('title'=>$text);
    }

    $result = 0;
    if (is_callable($compare_function)) {
        if (call_user_func_array($compare_function, array($path))) {
            // 条件が成立
            $result = 1;
        }
    }else {
        // 条件判断関数がない
        $result = 2;
    }
    switch ($result) {
        // 条件が成立しない場合
        case 0:
            if (is_array($false_options)) {
                $default_options = array_merge(
                                        $default_options,
                                        $false_options);
            }
            break;
        // 条件が成立した場合
        case 1:
            if (is_array($true_options)) {
                $default_options = array_merge(
                                        $default_options,
                                        $true_options);
            }
            break;
        default:
            // 何もしない
    }

    return link_to_page($text, $path, $default_options);
}

/**
 * link_to_page()
 * 特定のページ（パス）に対応するURLでリンクタグを生成する
 *
 * @param  string $text             リンクを設定する文字列
 * @param  string $page_path        リンク先ページのパス
 * @param  array  $default_options  link_to()ヘルパーへのオプション配列
 * @return string リンクタグ
 */
function link_to_page($text, $page_path, $default_options = array())
{
    $url = url_for_page($page_path);
    return link_to($text, $url, $default_options);
}

/**
 * url_for_page()
 * 特定のページ（パス）に対応するURLを求める
 *
 * @param  string $page_path        URLを求めるページのパス
 * @return string ページのパスに対応するURL
 */
function url_for_page($page_path) {
    //  ホームページパスに連結する
    $url = url_for('@homepage') . '/' . $page_path;

    //  余分なスラッシュを削除する
    $url = preg_replace('/\/+/', '/', $url);

    return $url;
}

/**
 * renderIndexItemList()
 * 階層付の索引を出力する。
 * データ構造は以下のようなオブジェクトの配列
 * array(
 *   StdClass (
 *     'type'->'h1',
 *     'text'->'hogehoge',
 *     'id'->'hogehoge',
 *     'children'->array(
 *       StdClass (
 *         'type'->'h2',
 *         'text'->'foobar',
 *         'id'->'foobar',
 *         'children'->array(
 *         )
 *       )
 *     )
 *   )
 * )
 *
 * @param mixed $list
 * @return string
 */
function renderIndexItemList($list)
{
    $ret = '';
    if (count($list) < 1) {
        return '';
    }
    $ret .= "\n<ul>\n";
    foreach ($list as $element) {
        $ret .= renderIndexItem($element);
    }
    $ret .= "</ul>\n";

    return $ret;
}

/**
 * renderIndexItem()
 *
 * @param mixed $element
 * @return string
 */
function renderIndexItem($element)
{
    $ret = '';
    if (!is_object($element)) {
        return '';
    }
    $ret .= '<li><a href="#' . $element->id . '">' . $element->text . '</a>';
    $ret .= renderIndexItemList($element->children);
    $ret .= "</li>\n";

    return $ret;
}