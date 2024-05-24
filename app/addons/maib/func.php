<?php

if (!defined('AREA')) {
    die('Access denied');
}

use Tygh\Tygh;
use Tygh\Registry;
use Tygh\Enum\NotificationSeverity;
use MaibEcomm\MaibSdk\MaibApiRequest;
use MaibEcomm\MaibSdk\MaibAuthRequest;

require_once 'payments/MaibApiRequest.php';
require_once 'payments/MaibAuthRequest.php';

/**
 * Installs maib payment processor
 *
 * @return void
 */
function fn_maib_install()
{
    /** @var \Tygh\Database\Connection $db */
    $db = Tygh::$app['db'];

    if ($db->getField('SELECT processor_id FROM ?:payment_processors WHERE processor_script = ?s', 'maib.php')) {
        return;
    }

    $db->query(
        'INSERT INTO ?:payment_processors ?e',
        [
            'processor'          => 'Maib',
            'processor_script'   => 'maib.php',
            'processor_template' => 'views/orders/components/payments/cc_outside.tpl',
            'admin_template'     => 'maib.tpl',
            'callback'           => 'N',
            'type'               => 'P',
            'addon'              => 'maib',
        ]
    );
}

/**
 * Disables maib payment methods upon add-on uninstallation.
 *
 * @return void
 */
function fn_maib_uninstall()
{
    /** @var \Tygh\Database\Connection $db */
    $db = Tygh::$app['db'];

    $processor_id = $db->getField(
        'SELECT processor_id FROM ?:payment_processors WHERE processor_script = ?s',
        'maib.php'
    );

    if (!$processor_id) {
        return;
    }

    $db->query('DELETE FROM ?:payment_processors WHERE processor_id = ?i', $processor_id);
    $db->query(
        'UPDATE ?:payments SET ?u WHERE processor_id = ?i',
        [
            'processor_id'     => 0,
            'processor_params' => '',
            'status'           => 'D',
        ],
        $processor_id
    );

    $db->query("DELETE FROM ?:language_values WHERE name LIKE '%maib.%'");
}

/**
 * Generate access token for maib payment
 * 
 * @param array $data
 * 
 * @return string
 */
function fn_maib_get_access_token(array $data)
{
    $project_id = $data['processor_params']['project_id'];
    $project_secret = $data['processor_params']['project_secret'];
    $signature_key = $data['processor_params']['project_signature'];

    // Check if access token exists in cache and is not expired
    if (
        Registry::get('maib_access_token') &&
        Registry::get('maib_access_token_expires') > time()
    ) {
        $access_token = Registry::get('maib_access_token');

        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Succesful received Access Token from cache.',
            'response' => '',
        ));

        return $access_token;
    }

    try {
        // Initiate Get Access Token Request to maib API
        $response = MaibAuthRequest::create()->generateToken(
            $project_id,
            $project_secret
        );

        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Succesful received Access Token from maib API',
            'response' => '',
        ));

        $access_token = $response->accessToken;

        // Store the access token and its expiration time in cache
        Registry::set('maib_access_token', $access_token);
        Registry::set('maib_access_token_expires', time() + $response->expiresIn);
    } catch (Exception $ex) {
        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Access token error: ' . $ex->getMessage(),
            'response' => '',
        ));

        fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.payment_error', [
            '[error]' => $ex->getMessage()
        ]));

        fn_redirect(fn_url('checkout.checkout'));
    }

    return $access_token;
}

/**
 * Hook handler
 */
function fn_maib_change_order_status_post(
    $order_id,
    $status_to,
    $status_from,
    $force_notification,
    $place_order,
    $order_info,
    $edp_data
) {
    if (!isset($order_id) || !isset($status_to) || !isset($status_from)) {
        return;
    }

    if (empty($order_info) || strtolower($order_info['payment_method']['processor']) != 'maib' || $status_to != $order_info['payment_method']['processor_params']['refunded_status_id']) {
        return;
    }

    fn_log_event('requests', 'http', array(
        'url' => '',
        'data' => 'Initiate Refund Payment Request to maib API, pay_id: ' . $order_info['payment_id'] . ', order_id: ' . $order_id,
        'response' => '',
    ));

    $params = ['payId' => strval($order_info['payment_id'])];

    try {
        // Initiate Refund Payment Request to maib API
        $response = MaibApiRequest::create()->refund(
            $params,
            fn_maib_get_access_token($order_info['payment_method'])
        );

        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Response from refund endpoint: ' . json_encode($response, JSON_PRETTY_PRINT) . ', order_id: ' . $order_id,
            'response' => '',
        ));

        if ($response && $response->status === "OK") {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Full refunded payment ' . $order_info['payment_id'] . ' for order ' . $order_id,
                'response' => '',
            ));

            fn_change_order_status(
                (int) $order_info['order_id'],
                $status_to,
                $status_from,
                fn_get_notification_rules(['notify_user' => true])
            );
        } else if ($response && $response->status === "REVERSED") {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Already refunded payment ' . $order_info['payment_id'] . ' for order ' . $order_id,
                'response' => '',
            ));
        } else {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Failed refund payment ' . $order_info['payment_id'] . ' for order ' . $order_id,
                'response' => '',
            ));
        }
    } catch (Exception $e) {
        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Failed refund payment ' . $order_info['payment_id'] . ' for order ' . $order_id,
            'response' => '',
        ));
    }
}