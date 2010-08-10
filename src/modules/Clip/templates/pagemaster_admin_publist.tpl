
{include file='pagemaster_admin_header.tpl'}

{if $pubtype.orderby eq 'core_pid'}
    {assign var='orderby_core_pid' value='core_pid:desc'}
{else}
    {assign var='orderby_core_pid' value='core_pid'}
{/if}
{if $pubtype.orderby eq 'core_title'}
    {assign var='orderby_core_title' value='core_title:desc'}
{else}
    {assign var='orderby_core_title' value='core_title'}
{/if}
{if $pubtype.orderby eq 'core_author'}
    {assign var='orderby_core_author' value='core_author:desc'}
{else}
    {assign var='orderby_core_author' value='core_author'}
{/if}
{if $pubtype.orderby eq 'cr_date'}
    {assign var='orderby_cr_date' value='cr_date:desc'}
{else}
    {assign var='orderby_cr_date' value='cr_date'}
{/if}
{if $pubtype.orderby eq 'lu_date'}
    {assign var='orderby_lu_date' value='lu_date:desc'}
{else}
    {assign var='orderby_lu_date' value='lu_date'}
{/if}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname='core' src='folder_documents.gif' set='icons/large' __alt='Publications list'}</div>

    <h2>{gt text='Publications list'}</h2>

    {pmadminsubmenu tid=$pubtype.tid}

    {pager display='page' rowcount=$pager.numitems limit=$pager.itemsperpage posvar='startnum'}

    <table class="z-admintable">
        <thead>
            <tr>
                <th>
                    <a href="{modurl modname='PageMaster' type='admin' func='publist' tid=$pubtype.tid orderby=$orderby_core_pid}">
                        {gt text='PID'}
                    </a>
                </th>
                <th>
                    <a href="{modurl modname='PageMaster' type='admin' func='publist' tid=$pubtype.tid orderby=$orderby_core_title}">
                        {gt text='Title'}
                    </a>
                </th>
                <th>
                    {gt text='Revision'}
                </th>
                <th>
                    {gt text='State'}
                </th>
                <th>
                    <a href="{modurl modname='PageMaster' type='admin' func='publist' tid=$pubtype.tid orderby=$orderby_core_author}">
                        {gt text='Author'}
                    </a>
                </th>
                <th>
                    {gt text='Online'}
                </th>
                <th>
                    <a href="{modurl modname='PageMaster' type='admin' func='publist' tid=$pubtype.tid orderby=$orderby_cr_date}">
                        {gt text='Creation date'}
                    </a>
                </th>
                <th>
                    <a href="{modurl modname='PageMaster' type='admin' func='publist' tid=$pubtype.tid orderby=$orderby_lu_date}">
                        {gt text='Update date'}
                    </a>
                </th>
                <th>
                    {gt text='Options'}
                </th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$publist item='pubitem'}
            <tr class="{cycle values='z-odd,z-even'}">
                <td>{$pubitem.core_pid|safetext}</td>
                <td>{$pubitem[$pubtype.titlefield]|safetext}</td>
                <td>{$pubitem.core_revision|safetext}</td>
                <td>{$pubitem.__WORKFLOW__.state}</td>
                <td>
                    <a href="{modurl modname='Users' type='admin' func='modify' userid=$pubitem.core_author}">
                        {usergetvar name="uname" uid=$pubitem.core_author}
                    </a>
                </td>
                <td>{$pubitem.core_online|yesno}</td>
                <td>{$pubitem.cr_date|dateformat:'datetimebrief'}</td>
                <td>{$pubitem.lu_date|dateformat:'datetimebrief'}</td>
                <td>
                    <a href="{modurl modname='PageMaster' type='user' func='edit' tid=$pubtype.tid id=$pubitem.id goto='referer'}" title="{gt text='Edit'}">{img modname='core' src='xedit.gif' set='icons/extrasmall' __title='Edit'}</a>&nbsp;
                    <a href="{modurl modname='PageMaster' type='user' func='display' tid=$pubtype.tid id=$pubitem.id}" title="{gt text='View'}">{img modname='core' src='demo.gif' set='icons/extrasmall' __title='View'}</a>&nbsp;
                    <a href="{modurl modname='PageMaster' type='admin' func='history' tid=$pubtype.tid pid=$pubitem.core_pid}" title="{gt text='History'}">{img modname='core' src='clock.gif' set='icons/extrasmall' __title='History'}</a>
                </td>
            </tr>
            {foreachelse}
            <tr class="z-admintableempty"><td colspan="9">{gt text='No publications found.'}</td></tr>
            {/foreach}
        </tbody>
    </table>
</div>
