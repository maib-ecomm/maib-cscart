INSERT INTO ?:payment_processors (processor, processor_script, processor_template, admin_template, callback, type, addon) VALUES ('MAIB', 'maib.php', 'views/orders/components/payments/cc_outside.tpl', 'maib.tpl', 'N', 'P', 'maib');

-- CREATE TABLE ?:maib_payments (
--     `id` INT UNSIGNED AUTO_INCREMENT,
--     `transaction_id` VARCHAR(32) NULL UNIQUE,
--     `amount` DECIMAL(10,2),
--     `currency_code` INT UNSIGNED NOT NULL,
--     `status` VARCHAR(20) NOT NULL,
--     `user_id` INT UNSIGNED NOT NULL DEFAULT 0,
--     `params` TEXT NULL,
--     `ip` VARCHAR(128) NULL,
--     `company_id` INT UNSIGNED NOT NULL DEFAULT 0,
--     `created_at` INT UNSIGNED NOT NULL DEFAULT 0,
--     `updated_at` INT UNSIGNED NOT NULL DEFAULT 0,
--     PRIMARY KEY (`id`)
-- ) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO ?:language_values (lang_code, name, value) VALUES
    ('en', 'maib.addon_is_disabled', 'Addon is disabled'),
    ('ro', 'maib.addon_is_disabled', 'Modulul nu este activ'),
    ('ru', 'maib.addon_is_disabled', 'Модуль выключен'),

    ('en', 'maib.configuration_maibmerchants', 'Configuration maibmerchants.md'),
    ('ro', 'maib.configuration_maibmerchants', 'Setări maibmerchants.md'),
    ('ru', 'maib.configuration_maibmerchants', 'Настройки maibmerchants.md'),

    ('en', 'maib.project_id', 'Project ID'),
    ('ro', 'maib.project_id', 'ID proiect'),
    ('ru', 'maib.project_id', 'ID проекта'),

    ('en', 'maib.project_id_description', 'Project ID from maibmerchants.md'),
    ('ro', 'maib.project_id_description', 'ID-ul proiectului din maibmerchants.md'),
    ('ru', 'maib.project_id_description', 'ID проекта из maibmerchants.md'),

    ('en', 'maib.project_secret', 'Project Secret'),
    ('ro', 'maib.project_secret', 'Parola proiectului'),
    ('ru', 'maib.project_secret', 'Пароль проекта'),

    ('en', 'maib.project_secret_description', 'Project Secret from maibmerchants.md. It is available after project activation.'),
    ('ro', 'maib.project_secret_description', 'Parola proiectului din maibmerchants.md. Este disponibilă după activarea proiectului.'),
    ('ru', 'maib.project_secret_description', 'Пароль проекта из maibmerchants.md. Доступен после активации проекта.'),

    ('en', 'maib.project_signature', 'Signature Key'),
    ('ro', 'maib.project_signature', 'Cheia semnăturii'),
    ('ru', 'maib.project_signature', 'Ключ подписи'),

    ('en', 'maib.project_signature_description', 'Signature Key for validating notifications на Callback URL. It is available after project activation.'),
    ('ro', 'maib.project_signature_description', 'Cheia semnăturii pentru validarea notificărilor на Callback URL. Este disponibilă după activarea proiectului.'),
    ('ru', 'maib.project_signature_description', 'Ключ подписи для валидации уведомлений на Callback URL. Доступен после активации проекта.'),

    ('en', 'maib.ok_url', 'Ok URL'),
    ('ro', 'maib.ok_url', 'Ok URL'),
    ('ru', 'maib.ok_url', 'Ok URL'),

    ('en', 'maib.ok_url_description', 'Add this link to the Ok URL field in the maibmerchants Project settings.'),
    ('ro', 'maib.ok_url_description', 'Adăugați acest link în câmpul Ok URL din setările Proiectului în maibmerchants.'),
    ('ru', 'maib.ok_url_description', 'Добавьте эту ссылку в поле Ok URL в настройках проекта в maibmerchants.'),

    ('en', 'maib.fail_url', 'Fail URL'),
    ('ro', 'maib.fail_url', 'Fail URL'),
    ('ru', 'maib.fail_url', 'Fail URL'),

    ('en', 'maib.fail_url_description', 'Add this link to the Fail URL field in the maibmerchants Project settings.'),
    ('ro', 'maib.fail_url_description', 'Adăugați acest link în câmpul Fail URL din setările Proiectului în maibmerchants.'),
    ('ru', 'maib.fail_url_description', 'Добавьте эту ссылку в поле Fail URL в настройках проекта в maibmerchants.'),

    ('en', 'maib.callback_url', 'Callback URL'),
    ('ro', 'maib.callback_url', 'Callback URL'),
    ('ru', 'maib.callback_url', 'Callback URL'),

    ('en', 'maib.callback_url_description', 'Add this link to the Callback URL field in the maibmerchants Project settings.'),
    ('ro', 'maib.callback_url_description', 'Adăugați acest link în câmpul Callback URL din setările Proiectului în maibmerchants.'),
    ('ru', 'maib.callback_url_description', 'Добавьте эту ссылку в поле Callback URL в настройках проекта в maibmerchants.'),

    ('en', 'maib.configuration_order_status', 'Configuration Order Status'),
    ('ro', 'maib.configuration_order_status', 'Setãri stare comandã'),
    ('ru', 'maib.configuration_order_status', 'Настройки статуса заказа'),

    ('en', 'maib.pending_status_id', 'Pending payment'),
    ('ro', 'maib.pending_status_id', 'Platã în așteptare'),
    ('ru', 'maib.pending_status_id', 'Платеж в ожидании'),

    ('en', 'maib.completed_status_id', 'Completed payment'),
    ('ro', 'maib.completed_status_id', 'Platã cu succes'),
    ('ru', 'maib.completed_status_id', 'Успешная оплата'),

    ('en', 'maib.failed_status_id', 'Failed payment'),
    ('ro', 'maib.failed_status_id', 'Platã eșuatã'),
    ('ru', 'maib.failed_status_id', 'Неуспешная оплата'),

    ('en', 'maib.refunded_status_id', 'Refunded payment'),
    ('ro', 'maib.refunded_status_id', 'Platã returnatã'),
    ('ru', 'maib.refunded_status_id', 'Возврат платежа'),

    ('en', 'maib.refunded_status_id_description', 'For payment refund, update the order status to the selected status. The funds will be returned to the customer card.'),
    ('ro', 'maib.refunded_status_id_description', 'Pentru returnarea plății, actualizați starea comenzii la starea selectată. Suma va fi returnatã pe cardul clientului.'),
    ('ru', 'maib.refunded_status_id_description', 'Для возврата платежа обновите статус заказа на выбранного статуса. Средства будут возвращены на карту клиента.'),
    
    ('en', 'maib.payment_error', 'Payment failed! Please try again. [error]'),
    ('ro', 'maib.payment_error', 'Plata a eșuat! Vă rugăm să încercați din nou. [error]'),
    ('ru', 'maib.payment_error', 'Оплата не удалась! Пожалуйста, попробуйте еще раз. [error]'),
    
    ('en', 'maib.error_no_payment', 'Error no payment'),
    ('ro', 'maib.error_no_payment', 'Plata a eșuat! Vă rugăm să încercați din nou.'),
    ('ru', 'maib.error_no_payment', 'Оплата не удалась! Пожалуйста, попробуйте еще раз.'),
    
    ('en', 'maib.error_callback', 'This Callback URL works and should not be called directly!'),
    ('ro', 'maib.error_callback', 'Acest Callback URL funcționează și nu poate fi accesat direct!'),
    ('ru', 'maib.error_callback', 'Этот Callback URL работает и не должен вызываться напрямую!');