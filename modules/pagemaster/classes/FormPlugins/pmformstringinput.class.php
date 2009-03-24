<?php
/**
 * PageMaster
 *
 * @copyright   (c) PageMaster Team
 * @link        http://code.zikula.org/pagemaster/
 * @license     GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @version     $ Id $
 * @package     Zikula_3rdParty_Modules
 * @subpackage  pagemaster
 */

require_once('system/pnForm/plugins/function.pnformtextinput.php');

class pmformstringinput extends pnFormTextInput
{
    var $columnDef = 'C(512)';
    var $title     = _PAGEMASTER_PLUGIN_STRING;

    function getFilename()
    {
        return __FILE__; // FIXME: may be found in smarty's data???
    }
}