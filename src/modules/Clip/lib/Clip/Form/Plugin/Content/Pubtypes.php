<?php
/**
 * Clip
 *
 * @copyright  (c) Clip Team
 * @link       http://github.com/zikula-modules/clip/
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package    Clip
 * @subpackage Form_Plugin_Content
 */

/**
 * Plugin used to support pubtype lists on Clip Content Types.
 */
class Clip_Form_Plugin_Content_Pubtypes extends Zikula_Form_Plugin_DropdownList
{
    public function getFilename()
    {
        return __FILE__;
    }

    function load(Zikula_Form_View $view, &$params)
    {
        if (!$view->isPostBack()) {
            $this->setItems(Clip_Util_Selectors::pubtypes());
        }

        parent::load($view, $params);
    }
}
