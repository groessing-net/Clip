<?php
/**
 * Clip
 *
 * @copyright  (c) Clip Team
 * @link       http://code.zikula.org/clip/
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package    Clip
 * @subpackage View_Plugins
 */

/**
 * Displays the admin sub menu
 *
 * @author mateo
 * @param  $params['tid'] tid
 */
function smarty_function_clip_admin_submenu($params, $view)
{
    $dom = ZLanguage::getModuleDomain('Clip');

    $tid = (int)$params['tid'];

    if (!$tid) {
        return LogUtil::registerError(__f('Error! Missing argument [%s].', 'tid', $dom));
    }

    $pubtype = Clip_Util::getPubType($tid);

    // build the output
    $output  = '<div class="z-menu"><span class="z-menuitem-title">';
    $output .= '<span class="clip-option">'.DataUtil::formatForDisplay($pubtype['title']).'</span><span class="clip-option">&raquo;</span>';

    $func = FormUtil::getPassedValue('func', 'main');

    // pubtype form link
    $output .= '<span>';
    if ($func != 'pubtype') {
        $output .= DataUtil::formatForDisplayHTML('<a href="'.ModUtil::url('Clip', 'admin', 'pubtype', array('tid' => $tid)).'">'.__('Options', $dom).'</a>');
    } else {
        $output .= DataUtil::formatForDisplayHTML('<a>'.__('Options', $dom).'</a>');
    }
    $output .= '</span> | ';

    // edit fields link
    $output .= '<span>';
    if ($func != 'pubfields') {
        $output .= DataUtil::formatForDisplayHTML('<a href="'.ModUtil::url('Clip', 'admin', 'pubfields', array('tid' => $tid)).'">'.__('Fields', $dom).'</a>');
    } elseif (isset($params['field']) != '') {
        $output .= DataUtil::formatForDisplayHTML('<a href="'.ModUtil::url('Clip', 'admin', 'pubfields', array('tid' => $tid)).'#newpubfield">'.__('Fields', $dom).'</a>');
    } else {
        $output .= DataUtil::formatForDisplayHTML('<a href="#newpubfield">'.__('Fields', $dom).'</a>');
    }
    $output .= '</span> | ';

    // new article link
    $output .= '<span>';
    $output .= DataUtil::formatForDisplayHTML('<a href="'.ModUtil::url('Clip', 'user', 'edit', array('tid' => $tid, 'goto' => 'referer')).'">'.__('New publication', $dom).'</a>');
    $output .= '</span> | ';

    // pub list link
    $output .= '<span>';
    if ($func != 'publist') {
        $output .= DataUtil::formatForDisplayHTML('<a href="'.ModUtil::url('Clip', 'admin', 'publist', array('tid' => $tid)).'">'.__('Publication list', $dom).'</a>');
    } else {
        $output .= DataUtil::formatForDisplayHTML('<a>'.__('Publication list', $dom).'</a>');
    }

    // show code links
    if ($func == 'showcode') {
        $output .= '<br />';
        $output .= '<span class="clip-option">'.DataUtil::formatForDisplay(__('Generate templates', $dom)).'</span><span class="clip-option">&raquo;</span>';
        $output .= '<span>'.($params['mode'] == 'input'      ? '<a>' : '<a href="'.DataUtil::formatForDisplay(ModUtil::url('Clip', 'admin', 'showcode', array('tid' => $tid, 'mode' => 'input'))).'">') . __('Input template', $dom).'</a></span> | ';
        $output .= '<span>'.($params['mode'] == 'outputlist' ? '<a>' : '<a href="'.DataUtil::formatForDisplay(ModUtil::url('Clip', 'admin', 'showcode', array('tid' => $tid, 'mode' => 'outputlist'))).'">') . __('List template', $dom).'</a></span> | ';
        $output .= '<span>'.($params['mode'] == 'outputfull' ? '<a>' : '<a href="'.DataUtil::formatForDisplay(ModUtil::url('Clip', 'admin', 'showcode', array('tid' => $tid, 'mode' => 'outputfull'))).'">') . __('Display template', $dom).'</a></span> | ';
        $output .= '<span>'.($params['mode'] == 'blocklist'  ? '<a>' : '<a href="'.DataUtil::formatForDisplay(ModUtil::url('Clip', 'admin', 'showcode', array('tid' => $tid, 'mode' => 'blocklist'))).'">') . __('List block', $dom).'</a></span> | ';
        $output .= '<span>'.($params['mode'] == 'blockpub'   ? '<a>' : '<a href="'.DataUtil::formatForDisplay(ModUtil::url('Clip', 'admin', 'showcode', array('tid' => $tid, 'mode' => 'blockpub'))).'">') . __('Pub block', $dom).'</a></span>';
    } else {
        $output .= '</span> | ';
        $output .= '<span>'.DataUtil::formatForDisplayHTML('<a href="'.ModUtil::url('Clip', 'admin', 'showcode', array('tid' => $tid, 'mode' => 'input')).'">'.__('Generate templates', $dom).'</a>').'</span>';
    }

    $output .= '</span></div>';

    return $output;
}
