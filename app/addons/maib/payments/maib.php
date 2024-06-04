<?php

if (!defined('AREA')) {
    die('Access denied');
}

use Tygh\Enum\NotificationSeverity;
use MaibEcomm\MaibSdk\MaibApiRequest;
use Tygh\Tygh;

require_once 'MaibApiRequest.php';

if (defined('PAYMENT_NOTIFICATION')) {
    $order_id = !empty($_REQUEST['orderId']) ? (int) $_REQUEST['orderId'] : 0;
    $pay_id = !empty($_REQUEST['payId']) ? $_REQUEST['payId'] : 0;
    $order_info = fn_get_order_info($order_id);

    if ($mode == 'success') {
        if (!empty($pay_id) && !empty($order_id)) {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Return to Ok URL. Pay ID: ' . $pay_id . ', Order ID: ' . $order_id,
                'response' => '',
            ));
    
            if (!empty($order_info)) {
                fn_change_order_status(
                    (int) $order_info['order_id'],
                    $order_info['payment_method']['processor_params']['pending_status_id'],
                    $order_info['status'],
                    fn_get_notification_rules(['notify_user' => true])
                );
        
                fn_redirect(fn_url('checkout.complete?order_id=' . $order_id));
            }
            else {
                fn_log_event('requests', 'http', array(
                    'url' => '',
                    'data' => 'Ok URL: Order not found.',
                    'response' => '',
                ));
    
                fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.error_no_payment'));
    
                fn_redirect(fn_url('checkout.checkout'));
            }
        }
        else {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Ok URL: Invalid or missing payId/orderId.',
                'response' => '',
            ));

            fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.error_no_payment'));

            fn_redirect(fn_url('checkout.checkout'));
        }
    }

    if ($mode == 'fail') {
        if (!empty($pay_id) && !empty($order_id)) {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Return to Fail URL. Pay ID: ' . $pay_id . ', Order ID: ' . $order_id,
                'response' => '',
            ));

            if (!empty($order_info)) {
                fn_redirect(fn_url('checkout.checkout'));
            }
            else {
                fn_log_event('requests', 'http', array(
                    'url' => '',
                    'data' => 'Fail URL: Order not found.',
                    'response' => '',
                ));
    
                fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.error_no_payment'));
    
                fn_redirect(fn_url('checkout.checkout'));
            }
        }
        else {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Fail URL: Order not found.',
                'response' => '',
            ));

            fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.error_no_payment'));

            fn_redirect(fn_url('checkout.checkout'));
        }
    }

    if ($mode == 'return') {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.error_callback'));

            fn_redirect(fn_url('checkout.checkout'));
        }

        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        if (!isset($data['signature']) || !isset($data['result'])) {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Callback URL - Signature or Payment data not found in notification.',
                'response' => '',
            ));

            exit();
        }

        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Notification on Callback URL: ' . json_encode($data, JSON_PRETTY_PRINT),
            'response' => '',
        ));

        $data_result = $data['result']; // Data from "result" object
        $sortedDataByKeys = $this->sortByKeyRecursive($data_result); // Sort an array by key recursively
        $key = $order_info['payment_method']['processor_params']['project_signature']; // Signature Key from Project settings
        $sortedDataByKeys[] = $key; // Add checkout Secret Key to the end of data array
        $signString = implode(":", $sortedDataByKeys); // Implode array recursively
        $sign = base64_encode(hash("sha256", $signString, true)); // Result Hash

        $pay_id = isset($data_result['payId']) ? $data_result['payId'] : false;
        $order_id = isset($data_result['orderId'])
            ? (int) $data_result['orderId']
            : false;
        $status = isset($data_result['status'])
            ? $data_result['status']
            : false;

        if ($sign !== $data['signature']) {
            echo "ERROR";

            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Signature is invalid: ' . $sign,
                'response' => '',
            ));

            exit();
        }

        echo "OK";

        fn_log_event('requests', 'http', array(
            'url' => '',
            'data' => 'Signature is valid: ' . $sign,
            'response' => '',
        ));

        if (!$order_id || !$status) {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Callback URL - Order ID or Status not found in notification.',
                'response' => '',
            ));

            exit();
        }

        if ($status === "OK") {
            // Payment success logic
            $order_note = sprintf(
                "Payment_Info: %s",
                json_encode($data_result, JSON_PRETTY_PRINT)
            );

            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => $order_note,
                'response' => '',
            ));

            fn_change_order_status(
                (int) $order_info['order_id'],
                $order_info['payment_method']['processor_params']['completed_status_id'],
                $order_info['status'],
                fn_get_notification_rules(['notify_user' => true])
            );
        } else {
            // Payment failure logic
            $order_note = sprintf(
                "Payment_Info: %s",
                json_encode($data_result, JSON_PRETTY_PRINT)
            );

            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => $order_note,
                'response' => '',
            ));

            fn_change_order_status(
                (int) $order_info['order_id'],
                $order_info['payment_method']['processor_params']['failed_status_id'],
                $order_info['status'],
                fn_get_notification_rules(['notify_user' => true])
            );
        }

        exit();
    }
} else {
    $ok_url = fn_url('payment_notification.success?payment=maib', 'C');
    $fail_url = fn_url('payment_notification.fail?payment=maib', 'C');
    $callback_url = fn_url('payment_notification.return?payment=maib', 'C');

    $description = [];
    $product_items = [];

    foreach ($order_info['products'] as $item_id => $product) {
        $description[] = $product['amount'] . " x " . $product['product'];

        $product_items[] = [
            "id" => $product['product_id'],
            "name" => $product['product'],
            "price" => (float) $product['price'],
            "quantity" => (float) number_format(
                $product['amount'],
                1,
                ".",
                ""
            ),
        ];
    }

    $params = [
        "amount" => (float) $order_info['total'],
        "currency" => $order_info['secondary_currency'],
        "clientIp" => $order_info['ip_address'],
        "language" => $order_info['lang_code'],
        "description" => substr(implode(", ", $description), 0, 124),
        "orderId" => $order_info['order_id'],
        "clientName" => $order_info['firstname'] . ' ' . $order_info['lastname'],
        "email" => $order_info['email'],
        "phone" => substr($order_info['phone'], 0, 40),
        "delivery" => (float) $order_info['shipping_cost'],
        "okUrl" => $ok_url,
        "failUrl" => $fail_url,
        "callbackUrl" => $callback_url,
        "items" => $product_items,
    ];

    fn_log_event('requests', 'http', array(
        'url' => '',
        'data' => 'Order params: ' . json_encode($params, JSON_PRETTY_PRINT) . ', order_id: ' . $order_id,
        'response' => '',
    ));

    try {
        // Initiate Direct Payment Request to maib API
        $response = MaibApiRequest::create()->pay(
            $params,
            fn_maib_get_access_token($processor_data)
        );

        if (!isset($response->payId)) {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'No valid response from maib API, order_id: ' . $order_id,
                'response' => '',
            ));

            fn_redirect(fn_url('checkout.checkout'));
        } else {
            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Pay endpoint response: ' . json_encode($response, JSON_PRETTY_PRINT) . ', order_id: ' . $order_id,
                'response' => '',
            ));

            $cart = &Tygh::$app['session']['cart'];
            fn_extract_cart_content($cart, $auth['user_id']);

            fn_update_order($cart, $order_id);

            fn_change_order_status(
                (int) $order_info['order_id'],
                $processor_data['processor_params']['pending_status_id'],
                $order_info['status'],
                fn_get_notification_rules(['notify_user' => true])
            );

            fn_log_event('requests', 'http', array(
                'url' => '',
                'data' => 'Redirect to pay url from maib API: ' . json_encode($response->payUrl, JSON_PRETTY_PRINT) . ', order_id: ' . $order_id,
                'response' => '',
            ));

            fn_clear_cart($cart);
            fn_save_cart_content($cart, $auth['user_id']);

            header('Location: ' . $response->payUrl);
        }
    } catch (Exception $ex) {
        fn_set_notification(NotificationSeverity::ERROR, __('error'), __('maib.payment_error', [
            '[error]' => $ex->getMessage()
        ]));

        fn_redirect(fn_url('checkout.checkout'));
    }
}

// Helper function: Sort an array by key recursively
function sortByKeyRecursive(array $array)
{
    ksort($array, SORT_STRING);
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = sortByKeyRecursive($value);
        }
    }
    return $array;
}
exit;