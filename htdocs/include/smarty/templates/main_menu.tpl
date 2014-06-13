<div id="main_menu">
  <ul>
    {foreach key=key item=value from=$items}
    {if isset($selected) and $selected == $value}
    <li id="selected">{$value}</li>
    {else}
    <li><a href="{$baselink}{$key}">{$value}</a></li>
    {/if}
    {/foreach}
  </ul>
  <br>
</div>
