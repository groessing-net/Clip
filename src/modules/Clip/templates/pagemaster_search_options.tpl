
<input type="hidden" id="active_PageMaster" name="PageMaster" value="1" checked="checked" />

{foreach from=$pubtypes item=pubtype}
<div>
    <input type="checkbox" id="PageMaster{$pubtype.tid}" name="search_tid[{$pubtype.tid}]" value="1" checked="checked" />
    <label for="PageMaster{$pubtype.tid}">{gt text=$pubtype.title}</label>
</div>
{/foreach}
