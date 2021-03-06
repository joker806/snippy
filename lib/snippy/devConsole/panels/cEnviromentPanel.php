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
use snippy\devConsole\iDevConsolePanel;

class cEnviromentPanel implements iDevConsolePanel
{
	/**
	 * @var snippy\debug\cHTMLFormater
	 */
	protected $formater;
	
	/**
	 * @var array
	 */
	protected $data;

	/**
	 * Constructor
	 *
	 * @param cLogBar|null $logBar
	 */
	public function __construct( cHTMLFormater $formater )
	{
		$this->formater = $formater;

		$this->data['$_SESSION'] = isset( $_SESSION ) ? $_SESSION : null;
		$this->data['$_SERVER']  = $_SERVER;
		$this->data['$_POST']    = $_POST;
		$this->data['$_GET']     = $_GET;
		$this->data['$_COOKIE']  = $_COOKIE;
	}

	/**
	 * Returns panel unique ID
	 */
	public function getID()
	{
		return 'env';
	}

	/**
	 * Returns name of panel
	 */
	public function getTitle()
	{
		return 'Enviroment';
	}

	/**
	 * Renders panel content
	 */
	public function render()
	{
		ob_start();
		
		$requestHeaders = array();
		foreach( $this->data['$_SERVER'] as $k => $v ) {
			if( substr( $k, 0, 5 ) != 'HTTP_' )
				continue;

			$name = substr( $k, 5 );
			$name = str_replace( '_', ' ', $name );
			$name = ucwords( strtolower( $name ) );
			$name = str_replace( ' ', '-', $name );

			$requestHeaders[$name] = $v;
		}

		$responseHeaders = headers_list();

		$constants = get_defined_constants( true );
		$settings  = $constants['user'];



		$columnStyle = 'vertical-align: top; padding: 3px 7px; ';

		echo "<fieldset><legend>Request</legend>";
		$this->printVars( array(
			'$_POST'   => $this->data['$_POST'],
			'$_GET'    => $this->data['$_GET'],
			'$_COOKIE' => $this->data['$_COOKIE'],
			'Request headers' => $requestHeaders
		));
		echo '</fieldset>';

		echo "<fieldset><legend>Response</legend>";
		$this->printVars( array(
			'Response headers' => $responseHeaders
		));
		echo '</fieldset>';

		echo "<fieldset><legend>Enviroment</legend>";
		$this->printVars( array(
			'$_SESSION' => $this->data['$_SESSION'],
			'$_SERVER'  => $this->data['$_SERVER'],
			'Settings'  => $settings
		));
		echo '</fieldset>';
	
		return ob_get_clean();
	}

	protected function printVars( $data )
	{
		echo '<table><tr>';
		foreach( $data as $title => $values  ) {
			if( $values !== null ) {
				echo "<th>{$title}</th>";
			}
		}

		echo '</tr><tr>';

		foreach( $data as $title => $values  ) {
			if( $values !== null ) {
				echo '<td>'.$this->formater->formatListVertical( $values ).'</td>';
			}
		}

		echo '</tr></table>';
	}
}