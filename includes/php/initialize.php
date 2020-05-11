<?php
/*
 * Make sure to disable the display of errors in production code!
 */
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once __DIR__. '/../libs/mollie-api-php/vendor/autoload.php';

/*
 * Initialize the Mollie API library with your API key.
 *
 * See: https://www.mollie.com/dashboard/developers/api-keys
 */
$GLOBALS['mollie'] = new \Mollie\Api\MollieApiClient();


if (!function_exists('cf7_mollie_setapikey')) {
	function cf7_mollie_setapikey($formid=""){
		$mollie = $GLOBALS['mollie'];
		$globalapi=get_option("CF7_mollie_global_key");
		//If the formid is given check for a custom api key, else use the global one
		//Check if a custom api key is already set
		if ($formid!=""){
			$formApi = get_post_meta( $formid, "CF7_mollie_apikey",true) ;
			try{
				if ($formid != null and $formApi) {
					$mollie->setApiKey($formApi);
				}elseif($globalapi){
					$mollie->setApiKey($globalapi);
				}
			} catch (\Mollie\Api\Exceptions\ApiException $e) {
				echo "Initialize 1: API call failed: " . htmlspecialchars($e->getMessage());
			}
		}elseif ($globalapi != ""){
			try{
				$mollie->setApiKey($globalapi);
			} catch (\Mollie\Api\Exceptions\ApiException $e) {
				echo "Initialize 2: API call failed: " . htmlspecialchars($e->getMessage());
			}
		}
	}
}
