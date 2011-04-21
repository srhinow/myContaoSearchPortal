<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * @copyright  Helmut Schottmüller <contao@aurealis.de>
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Frontend
 * @license    LGPL
 * @filesource
 */


/**
 * Class ContentHeadline
 *
 * Front end content element "headline".
 * @copyright  Helmut Schottmüller <contao@aurealis.de>
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */
class ContentHeadlineTags extends ContentHeadline
{
	/**
	 * Parse the template
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'FE') if ($this->tagsonly) if (!strlen($this->Input->get('tag'))) return;
		return parent::generate();
	}
}

?>