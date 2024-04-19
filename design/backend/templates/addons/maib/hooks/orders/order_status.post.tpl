{if $maib_incomplete_order}
<div>
    {assign var="check_payment_status" value=__("maib.check_payment_status")}
    <a href="{"maib_order.check?order_id=`$order_info.order_id`&return=`$extra_status`"|fn_url}" class="btn btn-primary">{$check_payment_status}</a>
</div>
{/if}
    