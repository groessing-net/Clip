<?php
/**
 * Clip
 *
 * @copyright  (c) Clip Team
 * @link       http://code.zikula.org/clip/
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package    Clip
 * @subpackage Lib
 */

/**
 * Clip Util.
 */
class Clip_Util
{
    /**
     * Arguments store.
     *
     * @var array
     */
    protected static $args = array();

    /**
     * self::$args getter.
     */
    public static function getArgs($id=null)
    {
        if ($id && isset(self::$args[$id])) {
            return self::$args[$id];
        }

        return self::$args;
    }

    /**
     * self::$args setter.
     */
    public static function setArgs($id, $args)
    {
        self::$args[$id] = $args;
    }

    /**
     * Extract the TID from a string end.
     *
     * @param string $tablename
     *
     * @return integer Publication type ID.
     */
    public static function getDefaultCategoryID()
    {
        static $id;

        if (!isset($id)) {
            $id = CategoryRegistryUtil::getRegisteredModuleCategory('Clip', 'clip_pubtypes', 'Global');
        }

        return $id;
    }

    /**
     * Format the orderby parameter.
     *
     * @param string $orderby
     *
     * @return string Formatted orderby.
     */
    public static function createOrderBy($orderby)
    {
        if (!is_array($orderby)) {
            $orderbylist = explode(',', $orderby);
        } else {
            $orderbylist = $orderby;
        }

        $orderbylist = array_map('trim', $orderbylist);

        $orderby = '';
        foreach ($orderbylist as $key => $value) {
            if ($key > 0) {
                $orderby .= ', ';
            }
            // $value = {col[:asc|desc]}
            $value    = explode(':', $value);
            $orderby .= DataUtil::formatForStore($value[0]);
            $orderby .= (isset($value[1]) && in_array(strtoupper($value[1]), array('ASC', 'DESC')) ? ' '.strtoupper($value[1]) : '');
        }

        return $orderby;
    }

    /**
     * Name reference generator.
     *
     * @return string Random id.
     */
    public static function getNewFileReference()
    {
        $chars   = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charLen = strlen($chars);

        $id = '';

        for ($i = 0; $i < 30; ++ $i) {
            $id .= $chars[mt_rand(0, $charLen-1)];
        }

        return $id;
    }

    /**
     * Extract the filter from the input to build a cacheid.
     *
     * @param string $varname Name of the filter variable on use.
     *
     * @see FilterUtil::getFiltersFromInput()
     *
     * @return string Filter id to use inside cacheid.
     */
    public static function getFilterCacheId($varname = 'filter')
    {
        $i = 1;
        $filterid = array();

        // Get unnumbered filter string
        $filterStr = FormUtil::getPassedValue($varname, '');
        if (!empty($filterStr)) {
            $filterid[] = urldecode($filterStr);
        }

        // Get filter1 ... filterN
        while (true) {
            $filterStr = FormUtil::getPassedValue("{$varname}{$i}", '');

            if (empty($filterStr)) {
                break;
            }

            $filterid[] = urldecode($filterStr);
            ++$i;
        }

        if (count($filterid) > 0) {
            $filterid = implode('__', $filter);
        }

        return self::getFilterCacheString($filterid);
    }

    /**
     * Replace some critical vars of the filter definition.
     *
     * @param string $filter Filter definition.
     *
     * @return string Filter string to use inside cacheid.
     */
    public static function getFilterCacheString($filter)
    {
        return str_replace(array('(', ')', '*', ','), array('-', '-', '__', '___'), $filter);
    }

    /**
     * Validates that a value is not a reserved word.
     *
     * @param string $value
     *
     * @return boolean True on valid, false on reserved word.
     */
    public static function validateReservedWord($value)
    {
        $dom = ZLanguage::getModuleDomain('Clip');

        $reservedwords = array(
            'module', 'func', 'type', 'tid', 'pid', '__WORKFLOW__',
            'submit', 'edit', __('submit', $dom), __('edit', $dom)
        );

        return (in_array($value, $reservedwords) || strpos('core_', $value) === 0);
    }

    /**
     * Validates a TID number.
     *
     * @param integer $tid
     *
     * @return boolean True on valid publication type, false otherwise.
     */
    public static function validateTid($tid)
    {
        if (is_numeric($tid) && $tid > 0 && self::getPubType($tid)) {
            return true;
        }

        return false;
    }

    /**
     * Extract the TID from a string end.
     *
     * @param string $tablename
     *
     * @return integer Publication type ID.
     */
    public static function getTidFromString($tablename)
    {
        $tid = '';
        while (is_numeric(substr($tablename, -1))) {
            $tid = substr($tablename, -1) . $tid;
            $tablename = substr($tablename, 0, strlen($tablename) - 1);
        }

        return $tid;
    }

    /**
     * Removes any numerical suffix of a string.
     *
     * @param string $string
     *
     * @return string String without numeric suffix.
     */
    public static function getStringPrefix($string)
    {
        $suffixnumber = self::getTidFromString($string);

        return str_replace($suffixnumber, '', $string);
    }

    /**
     * PubType getter.
     *
     * @param integer $tid Pubtype ID.
     *
     * @return Clip_Model_Pubtype Information of one or all the pubtypes.
     */
    public static function getPubType($tid = -1)
    {
        static $pubtypes;

        if (!isset($pubtypes)) {
            $pubtypes = Doctrine_Core::getTable('Clip_Model_Pubtype')->getPubtypes();
        }

        if ($tid == -1) {
            return $pubtypes;
        }

        $keys = array_keys($pubtypes->toArray());
        foreach ($keys as $key) {
            $pubtype = self::getPubTypeSub($pubtypes[$key], $tid);
            if ($pubtype != null) {
                return $pubtype;
            }
        }

        $null = null;
        return $null;
    }

    /* Utility function to return the pubtype reference */
    private static function getPubTypeSub(&$pubtype, $tid)
    {
        if ($pubtype['tid'] == $tid) {
            return $pubtype;
        }

        $null = null;
        return $null;
    }

    /**
     * Pubtype Relations getter.
     *
     * @param integer $tid Pubtype ID.
     * @param boolean $owningSide Wheter to fetch the owning side relations of the pubtype.
     *
     * @return array Relations for the passed pubtype.
     */
    public static function getRelations($tid = -1, $owningSide = true, $force = false)
    {
        static $relation_arr;

        if (!isset($relation_arr) || $force) {
            $relation_arr = Doctrine_Core::getTable('Clip_Model_Pubrelation')->getClipRelations();
        }

        $own = $owningSide ? 'own' : 'not';

        if ($tid == -1) {
            return $relation_arr[$own];
        }

        return isset($relation_arr[$own][$tid]) ? $relation_arr[$own][$tid] : array();
    }

    /**
     * PubFields getter.
     *
     * @param integer $tid     Pubtype ID.
     * @param string  $orderBy Field name to sort by.
     *
     * @return array Array of fields of one or all the loaded pubtypes.
     */
    public static function getPubFields($tid, $orderBy = 'lineno')
    {
        static $pubfields_arr;

        $tid = (int)$tid;
        if ($tid && !isset($pubfields_arr[$tid])) {
            $pubfields_arr[$tid] = Doctrine_Core::getTable('Clip_Model_Pubfield')
                                   ->selectCollection("tid = '$tid'", $orderBy, -1, -1, 'name');
        }

        return isset($pubfields_arr[$tid]) ? $pubfields_arr[$tid] : array();
    }

    /**
     * Title field getter.
     *
     * @param integer $tid Pubtype ID.
     *
     * @return array One or all the pubtype titles.
     */
    public static function getTitleField($tid = -1)
    {
        static $pubtitles_arr;

        if (!isset($pubtitles_arr)) {
            $pubtitles_arr = Doctrine_Core::getTable('Clip_Model_Pubfield')
                             ->selectFieldArray('name', "istitle = '1'", '', false, 'tid');
        }

        if ($tid == -1) {
            return $pubtitles_arr;
        }

        return isset($pubtitles_arr[(int)$tid]) ? $pubtitles_arr[(int)$tid] : 'id';
    }

    /**
     * Loop the pubfields array until get the title field.
     *
     * @param array $pubfields
     *
     * @return string Name of the title field.
     */
    public static function findTitleField($pubfields)
    {
        $core_title = 'id';

        if ($pubfields instanceof Doctrine_Collection) {
            $pubfields = $pubfields->toArray();
        }

        foreach (array_keys($pubfields) as $i) {
            if ($pubfields[$i]['istitle'] == 1) {
                $core_title = $pubfields[$i]['name'];
                break;
            }
        }

        return $core_title;
    }

    /**
     * Install the default 'blog' and 'staticpages' publication types.
     *
     * @return void
     */
    public static function installDefaultypes()
    {
        $dom = ZLanguage::getModuleDomain('Clip');

        $lang  = ZLanguage::getLanguageCode();
        $batch = new Clip_Import_Batch();

        $defaults = array('blog', 'staticpages');

        foreach ($defaults as $default) {
            // check if the pubtype exists
            $pubtype = Doctrine_Core::getTable('Clip_Model_Pubtype')->findByUrltitle($default);
            if (count($pubtype)) {
                LogUtil::registerStatus(__f("There is already a '%s' publication type.", $default, $dom));
            } else {
                // import the default XML
                $file = "modules/Clip/docs/xml/$lang/$default.xml";
                if (!file_exists($file)) {
                    $file = "modules/Clip/docs/xml/en/$default.xml";
                }

                if ($batch->setup(array('url' => $file)) && $batch->execute()) {
                    LogUtil::registerStatus(__f("Default '%s' publication type created successfully.", $default, $dom));
                } else {
                    LogUtil::registerStatus(__f("Could not import the '%s' publication type.", $default, $dom));
                }
            }
        }
    }

    /**
     * User form instance builder
     *
     * @param Zikula_Controller $controller
     * @see FormUtil::newForm
     *
     * @return Clip_Form_View User Form View instance.
     */
    public static function newUserForm(&$controller=null)
    {
        $serviceManager = ServiceUtil::getManager();
        $serviceId      = 'zikula.view.form.clip';

        if (!$serviceManager->hasService($serviceId)) {
            $view = new Clip_Form_View($serviceManager, 'Clip');
            $view->add_core_data();
            $serviceManager->attachService($serviceId, $view);
        } else {
            $view = $serviceManager->getService($serviceId);
        }

        if ($controller) {
            $view->setController($controller);
            $view->assign('controller', $controller);
        }

        return $view;
    }
}
