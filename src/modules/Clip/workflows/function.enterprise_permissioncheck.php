<?php
/**
 * PageMaster
 *
 * @copyright   (c) PageMaster Team
 * @link        http://code.zikula.org/pagemaster/
 * @license     GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package     Zikula_3rdParty_Modules
 * @subpackage  pagemaster
 */

/**
 * Permission check for workflow schema 'enterprise'
 *
 * @param array $obj
 * @param int $permLevel
 * @param int $currentUser
 * @param string $actionId
 * @return bool
 */
function PageMaster_workflow_enterprise_permissioncheck($obj, $permLevel, $currentUser, $actionId)
{
    if (!empty($obj)) {
        // process $obj and calculate an instance
        $pid = $obj['core_pid'];

        $tid     = PageMaster_Util::getTidFromStringSuffix($obj['__WORKFLOW__']['obj_table']);
        $pubtype = PageMaster_Util::getPubType($tid);

        if ($pubtype['enableeditown'] == 1 and $obj['core_author'] == $currentUser) {
            return true;
        } else {
            return SecurityUtil::checkPermission('pagemaster:input:', "$tid:$pid:$obj[__WORKFLOW__][state]", $permLevel, $currentUser);
        }
    } else {
        // no object passed - user wants to create a new one        
        $tid = FormUtil::getPassedValue('tid');

        return SecurityUtil::checkPermission('pagemaster:input:', "$tid::", $permLevel, $currentUser);
    }
}

function PageMaster_workflow_enterprise_gettextstrings()
{
    no__('Are you sure you want to delete this publication?');

    return array(
        'title' => no__('Enterprise'),
        'description' => no__("This is a three staged workflow with stages for untrusted submissions, editor's acceptance, and final approval control by a moderator."),

        // state titles
        'states' => array(
            no__('Waiting') => no__('Content has been submitted and is waiting for acceptance'),
            no__('Preview') => no__('Content has been accepted and is waiting for approval'),
            no__('Approved') => no__('Content has been approved is available online')
        ),

        // action titles and descriptions for each state
        'actions' => array(
            'initial' => array(
                no__('Submit and Approve') => no__('Submit a publication and approve immediately'),
                no__('Submit and Accept') => no__('Submit new content for approval'),
                no__('Submit') => no__('Submit new content for acceptance by the local editor')
            ),
            'waiting' => array(
                no__('Approve') => no__('Approve content for online publishing'),
                no__('Accept') => no__('Accept submitted content for later approval'),
                no__('Update') => no__('Save content with no workflow change'),
                no__('Reject') => no__('Reject and delete submitted content')
            ),
            'preview' => array(
                no__('Approve') => no__('Approve content for online publishing'),
                no__('Update') => no__('Update the publication'),
                no__('Delete') => no__('Delete the publication')
            ),
            'approved' => array(
                no__('Update and Approve') => no__('Update content and approve for online publishing'),
                no__('Update') => no__('Update content for approval'),
                no__('Publish') => no__('Make the publication available'),
                no__('Unpublish') => no__('Hide the publication'),
                no__('Move to depot') => no__('Move the publication to the depot'),
                no__('Delete') => no__('Delete the publication')
            )
        )
    );
}