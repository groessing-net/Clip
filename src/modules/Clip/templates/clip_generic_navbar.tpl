
<div class="z-menu">
    <span class="z-menuitem-title clip-menu">
        {strip}
        {checkpermissionblock component='clip::' instance="::" level=ACCESS_ADMIN}
        <span>
            <a href="{modurl modname='Clip' type='admin' func='main'}">
                {img width='12' height='12' modname='core' src='configure.png' set='icons/extrasmall' alt='' __title='Administration panel'}
            </a>
        </span>
        {/checkpermissionblock}
        {*
        {checkpermissionblock component='clip::' instance="`$pubtype.tid`::" level=ACCESS_EDIT}
        <span>
            <a href="{modurl modname='Clip' type='editor' func='view' tid=$pubtype.tid}">
                {img width='12' height='12' modname='core' src='lists.png' set='icons/extrasmall' alt='' __title='Editor panel'}
            </a>
        </span>
        {/checkpermissionblock}
        *}

        <span>&raquo;</span>
        {if $section neq 'list'}
            <span>
                <a href="{modurl modname='Clip' tid=$pubtype.tid}">
                    {gt text=$pubtype.title}
                </a>
            </span>
        {else}
            <span class="clip-breadtext">
                {gt text=$pubtype.title}
            </span>
        {/if}
        {checkpermissionblock component='clip:input:' instance="`$pubtype.tid`::" level=ACCESS_EDIT}
        <span>
            <a href="{modurl modname='Clip' type='user' func='edit' tid=$pubtype.tid}">
                {img width='12' height='12' modname='core' src='filenew.png' set='icons/extrasmall' alt='' __title='Add a publication'}
            </a>
        </span>
        {/checkpermissionblock}

        {if $section neq 'list' and $section neq 'pending'}
            <span class="text_separator">&raquo;</span>

            {if $section neq 'display'}
                {* edit check *}
                {if isset($pubdata.id)}
                <span>
                    <a href="{modurl modname='Clip' type='user' func='display' tid=$pubtype.tid pid=$pubdata.core_pid title=$pubdata.core_title|formatpermalink}" title="{$pubdata.core_title}">
                        {$pubdata.core_title|truncate:40}
                    </a>
                </span>
                {/if}
            {else}
                <span class="clip-breadtext" title="{$pubdata.core_title}">
                    {$pubdata.core_title|truncate:40}
                </span>
                {checkpermissionblock component='clip:input:' instance="`$pubtype.tid`::" level=ACCESS_ADD}
                <span>
                    <a href="{modurl modname='Clip' type='user' func='edit' tid=$pubdata.core_tid id=$pubdata.id}">
                        {img width='12' height='12' modname='core' src='edit.png' set='icons/extrasmall' __title='Edit' __alt='Edit'}
                    </a>
                </span>
                {/checkpermissionblock}
            {/if}

            {if $section neq 'display'}
                {if isset($pubdata.id)}
                <span class="text_separator">&raquo;</span>
                {/if}

                <span class="clip-breadtext">
                    {if isset($pubdata.id)}
                        {gt text='Edit'}
                    {else}
                        {gt text='Create'}
                    {/if}
                </span>
            {/if}
        {/if}
        {/strip}
    </span>
</div>

{insert name='getstatusmsg'}

{* Clip developer notices*}
{if isset($clip_generic_tpl) and $modvars.Clip.devmode|default:true}
    {* excludes simple templates *}
    {if $section neq 'pending'}

    {if $section eq 'display'}{zdebug}{/if}

    {checkpermissionblock component='clip::' instance='::' level=ACCESS_ADMIN}
    <div class="z-warningmsg">
        {if $section eq 'list' or $section eq 'display' or $section eq 'form'}
            {modurl modname='Clip' type='admin' func='showcode' code=$section tid=$pubtype.tid assign='urlcode'}
            {gt text='This is a generic template. Your can <a href="%s">get the autogenerated code here</a>, and read instructions on how to customize it.' tag1=$urlcode|safetext}
        <br />
        {/if}
        {modurl modname='Clip' type='admin' func='modifyconfig' fragment='devmode' assign='urlconfig'}
        {gt text='You can hide this message <a href="%s">disabling the development mode</a>.' tag1=$urlconfig|safetext}
    </div>
    {/checkpermissionblock}

    {/if}
{/if}
