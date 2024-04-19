<?php

use Tygh\Registry;

if (!defined('AREA')) {
    die('Access denied');
}

/**
 * Uninstall callback
 */
function fn_maib_delete_payment_processors()
{
    db_query("DELETE FROM ?:payment_processors WHERE processor_script = 'maib.php'");
    db_query("DROP TABLE ?:maib_payments");
    db_query("DELETE FROM ?:language_values WHERE name IN ('maib.debug_log', 'maib.private_key', 'maib.pkey_pass','maib.public_key','maib.transaction_type','maib.capture','maib.authorize','maib.addon_is_disabled','maib.return_urls','maib.delete_keys','maib.delete_warning','maib.pem_settings','maib.auto_pfx_extract','maib.auto_pfx_text','maib.auto_pfx_warning','maib.auto_pfx_file','maib.auto_pfx_pass','maib.private_note','maib.reverse_label','maib.reverse_link','maib.invalid_amount','maib.amount_to_reverse','maib.reverse_amount','maib.payment_not_yours','maib.check_payment_status') LIMIT 50");
}

/**
 * Hook save_log
 * We reuse orders/update event logging
 * and will alter $contents array to include additional info
 * @param $type
 * @param $action
 * @param $data
 * @param $user_id
 * @param $content
 * @param $event_type
 * @param $object_primary_keys
 * @see fn_log_event()
 */
function fn_maib_save_log($type, $action, $data, $user_id, &$content, &$event_type, $object_primary_keys)
{
    if ($type == 'orders' && $action == 'update') {
        if (isset($data['maib_transaction_id'])) {
            $content['message'] = 'MAIB transaction_id ' . $data['maib_transaction_id'];
        } elseif (isset($data['error'])) {
            $content['message'] = 'MAIB error: ' . $data['error'];
            // this should be logged as an error
            $event_type = 'E';
        }
    }
}