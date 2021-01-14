<?php
	/**
	 *
	 * Description
	 *
     * @package        Paystack\Utility
	 * @author         Michael Akanji <matscode@gmail.com>
	 *
	 */

	namespace Matscode\Paystack\Utility;

	class Http
	{
		public static function redirect( $location, $replace = true, $httpResponseCode = null )
		{
			// do a redirect
			header( 'Location: ' . $location, $replace, $httpResponseCode );
		}

	}