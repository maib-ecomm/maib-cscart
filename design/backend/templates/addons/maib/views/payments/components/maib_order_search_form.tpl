<div class="sidebar-row">
    <h6>{__("search")}</h6>

    {if $page_part}
        {assign var="_page_part" value="#`$page_part`"}
    {/if}

    <form action="{$smarty.request.dispatch|fn_url}{$_page_part}"
          name="{$product_search_form_prefix}search_form" method="get"
          class="cm-disable-empty {$form_meta}">
        <div class="sidebar-field">
            <label>{__("payment_id")}</label>
            <input type="text" name="id" value="{$smarty.request.id}" placeholder="0"/>
        </div>
        <div class="sidebar-field">
            <label>{__("user_id")}</label>
            <input type="text" name="filter[user_id]" value="{$smarty.request.filter.user_id}" placeholder="0"/>
        </div>
        <div class="sidebar-field">
            <label>{__("transaction_id")}</label>
            <input type="text" name="filter[transaction_id]" value="{$smarty.request.filter.transaction_id}" placeholder="0"/>
        </div>
        <div class="sidebar-field">
            <label>{__("status")}</label>
            <select name="filter[status]">
                <option value="" selected>{__('status')}</option>
                {foreach from=$order_status_list item="order_status_value"}
                    <option value="{$order_status_value}" {if $smarty.request.filter.status == $order_status_value}selected{/if}>{$order_status_value}</option>
                {/foreach}
            </select>
        </div>

        {include file="buttons/search.tpl" but_name="dispatch[`$dispatch`]"}
    </form>
</div>