{if $maib_was_used}
{include file="common/subheader.tpl" title=__("maib.reverse_label")}
<div class="control-group">
    <div>
        {assign var="maib_reverse_link" value=__("maib.reverse_link")}
        {include file="common/popupbox.tpl" id="maib_reverse_payment" content="" link_text="`$maib_reverse_link`<i class='icon icon-angle-right'></i>" act="link" href="{"maib_order.reverse?order_id=`$order_info.order_id`"|fn_url}" link_class="pull-right"}
    </div>
</div>
{/if}