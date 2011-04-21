/**
 * Class TagCloudRequest
 *
 * Provide methods to handle Ajax requests for tag clouds.
 * @copyright  Helmut Schottmüller 2009
 * @author     Helmut Schottmüller <typolight@aurealis.de>
 * @package    Backend
 */
var TagCloudRequest =
{

	/**
	 * Toggle the visibility of a tag cloud
	 * @param object
	 * @param integer
	 * @return boolean
	 */
	toggleTagCloud: function(el, pageID)
	{
		el.blur();
		display = (el.getParent().getNext().getStyle('display') == 'none') ? 'block' : 'none';
		el.getParent().getNext().setStyle('display', display); 
		(display == 'none') ? el.addClass('yes') : el.removeClass('yes');
		new Request({url: window.location.href, data: 'toggleTagCloud=1&cloudPageID=' + pageID + '&cloudID=' + el.id + '&display=' + display}).send();
		return false;
	}
};

window.addEvent('domready', function() {
  $(document.body).getElements('span').each(function(item, index){ if (item.hasClass('toggle-button')) { item.removeClass('off');  } });
});
