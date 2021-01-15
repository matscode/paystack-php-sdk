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

	class Text
	{
		/**
		 *
		 * @author Hackan <hackan@gmail.com>
		 * @link   https://php.net/manual/en/function.uniqid.php#120123
		 *
		 * @param int $length
		 *
		 * @param int $capsMix
		 *
		 * @return bool|string
		 * @throws \Exception
		 */
		public static function uniqueStr($length = 15, $capsMix = 5 )
		{
			// uniqid gives 15 chars, but you could adjust it to your needs.
			if ( function_exists( "random_bytes" ) ) {
				$bytes = random_bytes( ceil( $length / 2 ) );
			} elseif ( function_exists( "openssl_random_pseudo_bytes" ) ) {
				$bytes = openssl_random_pseudo_bytes( ceil( $length / 2 ) );
			} else {
				throw new \Exception( "No cryptographically secure random function available" );
			}

			if ( $capsMix > 10 ) {
				throw new \Exception( 'capsMix can not be greater than 10' );
			}
			$caps = substr( str_shuffle( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' ), 1, $capsMix );

			return str_shuffle( substr( bin2hex( $bytes ), 0, $length ) . $caps );
		}


        /**
         * @param string $string
         * @return string
         */
        public static function removeSlashes(string $string ): string
        {
			return trim( $string, '/' );
		}
	}