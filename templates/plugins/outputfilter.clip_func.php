<?php/**
 * Clip
 *
 * @copyright  (c) Clip Team
 * @link       http://github.com/zikula-modules/clip/
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package    Clip
 * @subpackage View_Plugins
 */
/**
 * Clip modfunc outputfilter plugin.
 *
 * @param string      $source Output source.
 * @param Zikula_View $view   Reference to Zikula_View instance.
 *
 * @return string Modified output source.
 */
function smarty_outputfilter_clip_func($source, $view)
{
    require_once $view->_get_plugin_filepath('function', 'modfunc');
    // detect all the clipfuncs
    $num = preg_match_all('/CLIPFUNC:(a:.*?\\})/', $source, $matches);
    for ($i = 0; $i < $num; $i++) {
        $params = unserialize($matches[1][$i]);
        // call the modfunc
        try {
            $output = smarty_function_modfunc($params, $view);
        } catch (Exception $e) {
            $output = $e->getMessage();
        }
        // replace them by the modfunc result
        $source = str_replace($matches[0][$i], $output, $source);
    }
    // return the modified source
    return $source;
}