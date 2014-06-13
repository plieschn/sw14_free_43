<div id="sub_menu">
  <ul>
    {foreach key=key item=value from=$items}
    {if $value|is_array}
    <li>
      <div><span class="sub_menu_category">{$key}</span>
        <ul>
          {foreach key=inner_key item=inner_value from=$value}
          {if $inner_value == $selected}
          <li>{$inner_value}</li>
          {else}
          <li><a href="{$baselink}{$main_item}/{$key}/{$inner_value}">{$inner_value}</a></li>
          {/if}
          {/foreach}
        </ul>
      </div>
    </li>
    {else}
    {if $value == $selected}
    <li>{$value}</li>
    {else}
    <li><a href="{$baselink}{$main_item}/{$value}">{$value}</a></li>
    {/if}
    {/if}
    {/foreach}
  </ul>
</div>
