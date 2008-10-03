<?php
/**
 * PageMaster
 *
 * @copyright (c) 2008, PageMaster Team
 * @link        http://code.zikula.org/pagemaster/
 * @license     GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package     Zikula_3rd_party_Modules
 * @subpackage  pagemaster
 */

function pagemaster_operation_updateOnlineState(&$obj, $params)
{
    $online = isset($params['online']) ? $params['online'] : false;
    $obj['core_online'] = $online;

    return (bool)DBUtil::updateObject($obj, $obj['__WORKFLOW__']['obj_table']);
}
