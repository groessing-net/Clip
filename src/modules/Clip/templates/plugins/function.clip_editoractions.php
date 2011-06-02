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
 * Plugin to display the available Editor's actions for an item.
 *
 * Available parameters:
 *  - pub    (object) Publication instance.
 *  - assign (string) Optional variable name to assign the result to.
 *
 * Examples:
 *
 *  For Clip access check:
 *  <samp>{clip_access permlvl=ACCESS_ADMIN}</samp>
 *
 *  For Grouptype access check:
 *  <samp>{clip_access gid=$gid}</samp>
 *
 *  For Pubtype access check:
 *  <samp>{clip_access tid=$pubtype}</samp>
 *
 *  For Publication edit access check:
 *  <samp>{clip_access tid=$pubtype.tid pid=$pubdata context='edit'}</samp>
 *
 * @param array       $params All parameters passed to this plugin from the template.
 * @param Zikula_View $view   Reference to the {@link Zikula_View} object.
 *
 * @return boolean
 */
function smarty_function_clip_editoractions($params, Zikula_View &$view)
{
    if (!isset($params['pub']) || !is_object($params['pub'])) {
        $view->trigger_error($view->__f('Error! in %1$s: the %2$s parameter must be specified.', array('clip_editoractions', 'pub')));
        return false;
    }

    $pub    = $params['pub'];
    $assign = isset($params['assign']) ? $params['assign'] : null;

    $pubtype  = Clip_Util::getPubType($pub['core_tid']);

    $workflow = new Clip_Workflow($pubtype, $pub);
    $actions  = $workflow->getActions(Clip_Workflow::ACTIONS_EXEC);

    // build the plugin output
    $output = '<div class="clip-editoractions">';

    // common action exec arguments
    $args = array('tid' => $pub['core_tid'], 'id' => $pub['id']);

    $links = array();

    // adds the edit link if has access to the form
    if (Clip_Access::toPub($pubtype, $pub)) {
        $links[] = '<span class="clip-ac-editform">'.
                   '  <a href="'.ModUtil::url('Clip', 'user', 'edit', $args).'" title="'.$view->__('Edit this publication').'">'.$view->__('Edit').'</a>'.
                   '</span>';
    }

    // loop the actions building their output
    foreach ($actions as $aid => $action) {
        //$class = isset($action['parameters']['link']['class']) ? $action['parameters']['link']['class'] : '';
        $args['action'] = $aid;
        $links[] = '<span class="clip-ac-'.$aid.'">'.
                   '  <a href="'.ModUtil::url('Clip', 'user', 'exec', $args).'" title="'.$action['description'].'">'.$action['title'].'</a>'.
                   '</span>';
    }
    $output .= implode(' <span class="text_separator">|</span> ', $links);

    $output .= '</div>';

    if ($assign) {
        $view->assign($assign, $output);
    } else {
        return $output;
    }
}