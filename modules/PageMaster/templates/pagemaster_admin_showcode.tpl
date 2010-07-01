{* $Id$ *}

{include file='pagemaster_admin_header.tpl'}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname='core' src='exec.gif' set='icons/large' __alt='Show code'}</div>

    <h2>{gt text='Show code'}</h2>

    {pmadminsubmenu tid=$pubtype.tid mode=$mode}

    {switch expr=$mode}
    {case expr='input'}
    {assign var='pmtplname' value='pubedit_'|cat:$pubtype.formname|cat:'_all.tpl'}
    {assign var='pmsubfolder' value='input'}
    <h3>{gt text='Input form template'}</h3>
    {/case}
    {case expr='outputlist'}
    {assign var='pmtplname' value='publist_'|cat:$pubtype.filename|cat:'.tpl'}
    {assign var='pmsubfolder' value='output'}
    <h3>{gt text='Publication list template'}</h3>
    {/case}
    {case expr='outputfull'}
    {assign var='pmtplname' value='viewpub_'|cat:$pubtype.filename|cat:'.tpl'}
    {assign var='pmsubfolder' value='output'}
    <h3>{gt text='Publication display template'}</h3>
    {/case}
    {/switch}

    <p class="z-warningmsg">
        {gt text='Create a template named <strong>%1$s</strong> with this code, and store it in the the directory: <strong>/config/templates/PageMaster/%2$s/%1$s</strong>, or within your theme in the <strong>/themes/YourTheme/templates/modules/PageMaster/%2$s/%1$s</strong>.' tag1=$pmtplname tag2=$pmsubfolder}
    </p>

    <pre class="pm-showcode">{$code}</pre>
</div>