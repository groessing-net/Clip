<?php/**
 * Smarty resource
 * 
 * @copyright  (c) Zikula Development Team
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @category   Zikula_3rdParty_Stuff
 * @package    Smarty
 * @subpackage Resource
 */
/**
 * Smarty Resource.
 * 
 * Fetches template from a Smarty object variable or a global one.
 */
function smarty_resource_var_source($tpl_name, &$tpl_source, &$smarty)
{
    if (isset($tpl_name) && !empty($tpl_name)) {
        // Check if the variable is assigned in the Smarty object
        if (isset($smarty->_tpl_vars[$tpl_name])) {
            $tpl_source = $smarty->_tpl_vars[$tpl_name];
            unset($smarty->_tpl_vars[$tpl_name]);
        } else {
            global ${$tpl_name};
            $tpl_source = ${$tpl_name};
        }
        return true;
    }
    return false;
}
function smarty_resource_var_timestamp($tpl_name, $tpl_timestamp, &$smarty)
{
    if (isset($tpl_name) && !empty($tpl_name)) {
        $tpl_timestamp = microtime();
        return true;
    }
    return false;
}
function smarty_resource_var_secure($tpl_name, &$smarty)
{
    // assume all variables are secure
    return true;
}
function smarty_resource_var_trusted($tpl_name, &$smarty)
{
    
}