<?php
/**
 * Clip
 *
 * @copyright  (c) Clip Team
 * @link       http://code.zikula.org/clip/
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package    Clip
 * @subpackage Workflows_Operations
 */

/**
 * notify operation.
 *
 * @param object $pub                Publication related with the notification.
 * @param bool   $params['silent']   Hide or display a status/error message, (optional) (default: false).
 * @param string $params['group']    Workflow group to be notified (optional) (default: editor).
 * @param string $params['type']     Type of notification, short-identifier of the event and template (optional) (default: update).
 * @param string $params['template'] Template to use for the notification message located on pubtype/notify_TPL.tpl (optional) (default: group_type).
 *
 * @return bool Always true, notification does not interrupt the workflow action execution.
 */
function Clip_operation_notify(&$pub, $params)
{
    $dom = ZLanguage::getModuleDomain('Clip');

    $silent   = isset($params['silent']) ? (bool)$params['silent'] : false;
    $group    = isset($params['group']) ? $params['group'] : 'editor';
    $type     = isset($params['type']) ? $params['type'] : 'update';
    $template = isset($params['template']) ? $params['template'] : "{$group}_{$type}";

    // utility vars
    $pubtype = Clip_Util::getPubType($pub['core_tid']);

    // create the View object
    $view = Zikula_View::getInstance('Clip');

    // locate the notification template to use
    $tplpath = $pubtype['folder'].'/notify_'.$template;

    if ($view->template_exists($tplpath)) {
        $view->assign('pub', $pub);

        $message = $view->fetch($template);

        // convention: first line is the subject
        //$subject = 

        // TODO Configuration of recipient groups
        //$recipients = ClipUtil::getPubTypeRecipients($group);

        if (ModUtil::available('Mailer')) {
            $ok = ModUtil::apiFunc('Mailer', 'user', 'sendmessage',
                                   array('toaddress' => $recipients,
                                         'subject'   => $subject,
                                         'body'      => $message,
                                         'html'      => true));
        } else {
            $ok = mail($recipients, $subject, $message);
        }

        // output message
        if (!$silent) {
            if ($ok) {
                LogUtil::registerStatus(__f("Notification sent to '%s' group.", $group, $dom));
            } else {
                LogUtil::registerStatus(__('Notification failed.', $dom));
            }
        }
    }

    return true;
}
