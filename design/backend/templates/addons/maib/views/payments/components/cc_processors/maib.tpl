{if $addons.maib.status == "D"}
    <div class="alert alert-block">
	    <p>
            {__("maib.addon_is_disabled")}
        </p>
    </div>
{else}
    {$order_statuses = $smarty.const.STATUSES_ORDER|fn_get_statuses}

    <h4>{__("maib.configuration_maibmerchants")}</h4>

    <div class="control-group">
        <label class="control-label" for="maib_project_id">
            {__("maib.project_id")}:
        </label>
        <div class="controls">
            <input name="payment_data[processor_params][project_id]" id="maib_project_id" type="text" value="{if $processor_params.project_id}{$processor_params.project_id}{/if}">
            <p class="muted description">
                {__("maib.project_id_description")}
            </p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_project_secret">
            {__("maib.project_secret")}:
        </label>
        <div class="controls">
            <input name="payment_data[processor_params][project_secret]" id="maib_project_secret" type="text" value="{if $processor_params.project_secret}{$processor_params.project_secret}{/if}">
            <p class="muted description">
                {__("maib.project_secret_description")}
            </p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_project_signature">
            {__("maib.project_signature")}:
        </label>
        <div class="controls">
            <input name="payment_data[processor_params][project_signature]" id="maib_project_signature" type="text" value="{if $processor_params.project_signature}{$processor_params.project_signature}{/if}">
            <p class="muted description">
                {__("maib.project_signature_description")}
            </p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_ok_url">
            {__("maib.ok_url")}:
        </label>
        <div class="controls">
            <p>
                {fn_url('payment_notification.return?payment=maib', 'C')}
            </p>
            <p class="muted description">
                {__("maib.ok_url_description")}
            </p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_fail_url">
            {__("maib.fail_url")}:
        </label>
        <div class="controls">
            <p>
                {fn_url('payment_notification.fail?payment=maib', 'C')}
            </p>
            <p class="muted description">
                {__("maib.fail_url_description")}
            </p>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_callback_url">
            {__("maib.callback_url")}:
        </label>
        <div class="controls">
            <p>
                {fn_url('payment_notification.return?payment=maib', 'C')}
            </p>
            <p class="muted description">
                {__("maib.callback_url_description")}
            </p>
        </div>
    </div>

    <h4>{__("maib.configuration_order_status")}</h4>

    <div class="control-group">
        <label class="control-label" for="maib_pending_status_id">
            {__("maib.pending_status_id")}:
        </label>
        <div class="controls">
            <select name="payment_data[processor_params][pending_status_id]" id="maib_pending_status_id">
                {foreach from=$order_statuses item="order_status" key="key"}
                    <option value="{$order_statuses[$key].status_id}" {if $processor_params.pending_status_id == $order_statuses[$key].status_id}selected{/if}>
                        {$order_statuses[$key].description}
                    </option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_completed_status_id">{__("maib.completed_status_id")}:</label>
        <div class="controls">
            <select name="payment_data[processor_params][completed_status_id]" id="maib_completed_status_id">
                {foreach from=$order_statuses item="order_status" key="key"}
                    <option value="{$order_statuses[$key].status_id}" {if $processor_params.completed_status_id == $order_statuses[$key].status_id}selected{/if}>
                        {$order_statuses[$key].description}
                    </option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_failed_status_id">{__("maib.failed_status_id")}:</label>
        <div class="controls">
            <select name="payment_data[processor_params][failed_status_id]" id="maib_failed_status_id">
                {foreach from=$order_statuses item="order_status" key="key"}
                    <option value="{$order_statuses[$key].status_id}" {if $processor_params.failed_status_id == $order_statuses[$key].status_id}selected{/if}>
                        {$order_statuses[$key].description}
                    </option>
                {/foreach}
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="maib_refunded_status_id">{__("maib.refunded_status_id")}:</label>
        <div class="controls">
            <select name="payment_data[processor_params][refunded_status_id]" id="maib_refunded_status_id">
                {foreach from=$order_statuses item="order_status" key="key"}
                    <option value="{$order_statuses[$key].status_id}" {if $processor_params.refunded_status_id == $order_statuses[$key].status_id}selected{/if}>
                        {$order_statuses[$key].description}
                    </option>
                {/foreach}
            </select>
            <p class="muted description">
                {__("maib.refunded_status_id_description")}
            </p>
        </div>
    </div>
{/if}