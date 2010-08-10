
{include file='pagemaster_admin_header.tpl'}

<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname='core' src='clock.gif' set='icons/large' __alt='History'}</div>

    <h2>{gt text='History'}</h2>

    {pmadminsubmenu tid=$pubtype.tid}

    <table class="z-admintable">
        <thead>
            <tr>
                <th>{gt text='PID'}</th>
                <th>{gt text='Title'}</th>
                <th>{gt text='Revision'}</th>
                <th>{gt text='State'}</th>
                <th>{gt text='Author'}</th>
                <th>{gt text='Online'}</th>
                <th>{gt text='In depot'}</th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$publist item='pubitem'}
            <tr class="{cycle values='z-odd,z-even'}">
                <td>{$pubitem.core_pid}</td>
                <td>{$pubitem[$pubtype.titlefield]}</td>
                <td>{$pubitem.core_revision}</td>
                <td>{$pubitem.__WORKFLOW__.state} </td>
                <td>{usergetvar name='uname' uid=$pubitem.core_author} </td>
                <td>{$pubitem.core_online}</td>
                <td>{$pubitem.core_indepot}</td>
            </tr>
            {foreachelse}
            <tr class="z-admintableempty"><td colspan="7">{gt text='No publications found.'}</td></tr>
            {/foreach}
        </tbody>
    </table>
</div>
