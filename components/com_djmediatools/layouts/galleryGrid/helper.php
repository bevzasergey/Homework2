<?php
/**
 * @version $Id: helper.php 5 2013-01-04 13:37:11Z szymon $
 * @package DJ-MediaTools
 * @copyright Copyright (C) 2012 DJ-Extensions.com LTD, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email contact@dj-extensions.com
 * @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
 *
 * DJ-MediaTools is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DJ-MediaTools is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DJ-MediaTools. If not, see <http://www.gnu.org/licenses/>.
 *
 */
 
// no direct access
defined('_JEXEC') or die ('Restricted access');

class GalleryGridDJMediatoolsLayoutHelper extends DJMediatoolsLayoutHelper
{
	
	public function addScripts(&$params) {
		
		$mid = $params->get('gallery_id');
		
		JHTML::_('behavior.framework');
		$document = JFactory::getDocument();
		
		if($params->get('link_image',1)==2) $this->addLightbox($params->get('lightbox','picbox'));
		
		$document->addScript('components/com_djmediatools/layouts/galleryGrid/js/galleryGrid.js');
		
		$animationOptions = "{".implode(',', $this->getAnimationOptions($params))."}";
		
		$className = ucfirst($this->_prefix);
		
		$js = "	window.addEvent('domready',function(){ this.DJGalleryGrid$mid = new DJImage$className('dj-$this->_prefix$mid',$animationOptions)});";
		//$js = "(function($){ ".$js." })(document.id);";
		$document->addScriptDeclaration($js);
	}
	
	public function getAnimationOptions(&$params) {
		
		$effect = $params->get('effect');
		$effect_type = $params->get('effect_type');
		$duration = $params->get('duration');
		$delay = $params->get('delay');
		
		$transition = $effect.'.';
		if(!$effect_type) $transition .= 'easeOut';
		else $transition .= $effect_type;
		if(!$duration) $duration = 300;
		if($delay > $duration) $delay = 50;
		
		$width = $params->get('image_width');
		if($params->get('desc_position')!='over') $width += $params->get('desc_width');
		
		$options[] = "transition: Fx.Transitions.$transition";
		$options[] = "duration: $duration";
		$options[] = "delay: $delay";
		$options[] = "desc_effect: '".$params->get('desc_effect')."'";
		$options[] = "width: $width";
		$options[] = "height: ".$params->get('image_height');
		$options[] = "spacing: ".$params->get('space_between_images');
		$options[] = "preload: ".$params->get('preload');
		
		return $options;
	}

	public function getStyleSheetParams(&$params) {
		
		$options = parent::getStyleSheetParams($params);
		
		$spacing = $params->get('space_between_images');
		$options[] = "s=$spacing";
		
		return $options;
	}
	
}
