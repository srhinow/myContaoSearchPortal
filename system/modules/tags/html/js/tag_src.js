/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Backend
 * @license    LGPL
 * @filesource
 */

/**
 * Class Tag
 *
 * Provide methods to handle back end tasks.
 * @copyright  Helmut Schottmüller 2008
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Backend
 */
var Tag =
{
	/**
	 * Select tags in a tag cloud
	 * @param string
	 * @param string
	 */
	selectedTag: function(tag, id)
	{
		textinput = $(id);
		value = textinput.value;
		expression = new RegExp('(,|^)(' + tag + ')\\s{0,}(,|$)', 'i');
		if (value.match(expression))
		{
			// tag was found -> remove it
			remove = new RegExp('(,|^)(' + tag + ')\\s{0,}(,|$)', 'i');
			replacement = (RegExp.$1 == ',' && RegExp.$3 == ',') ? ',' : '';
			value = value.replace(remove, replacement);
			textinput.value = value;
		}
		else
		{
			// tag wasn't found -> add it
			if (value.length == 0)
			{
				value = tag;
			}
			else
			{
				value = value.replace(/,{0,1}$/, ',' + tag);
			}
			textinput.value = value;
		}
	}
};