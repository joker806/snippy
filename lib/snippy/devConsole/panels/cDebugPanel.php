<?php
/**
 * This file is part of snippy.
 *
 * @author Josef Martinec <joker806@gmail.com>
 * @copyright Copyright (c) 2011, Josef Martinec
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace snippy\devConsole\panels;

use snippy\debug\cHTMLFormater;
use snippy\debug\iOutputItem;

use snippy\debug\iOutputWriter;
use snippy\devConsole\iDevConsolePanel;

class cDebugPanel implements iDevConsolePanel, iOutputWriter
{
	const TITLE = 'Debug';

	/**
	 * @var array
	 */
	protected $items;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var HTMLFormater
	 */
	protected $formater;

	/**
	 * Constructor
	 *
	 * @param string $title
	 */
	public function __construct( cHTMLFormater $formater )
	{
		$this->items    = array();
		$this->formater = $formater;
	}

	/**
	 * Returns panel unique ID
	 */
	public function getID()
	{
		return 'msgPanel_'.preg_replace( '/\s/', '_', self::TITLE );
	}

	/**
	 * Returns name of panel
	 */
	public function getTitle()
	{
		return self::TITLE;
	}

	/**
	 * Renders panel content
	 *
	 * @return string
	 */
	public function render()
	{
		ob_start();

		foreach( $this->items as $item ) {
			echo $item->render( $this->formater );
		}

		return ob_get_clean();
	}

	/**
	 * Writes debug item to output
	 *
	 * @param iItem $item
	 */
	public function write( iOutputItem $item )
	{
		$this->items[] = $item;
	}
}