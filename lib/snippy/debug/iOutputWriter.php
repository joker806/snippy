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

namespace snippy\debug;

interface iOutputWriter
{
	/**
	 * Writes debug item to output
	 *
	 * @param iOutputItem $item
	 */
	public function write( iOutputItem $item );
}