<!DOCTYPE html>
<html>
  <head>
    <style type="text/css" media="screen">
    </style>
    {include file="head.tpl"}
  </head>
  <body>
    {include file="heading.tpl"}
    {include file='main_menu.tpl' baselink=$baselink items=$main_menu_items}

    <div id="content">
      <h2>Login</h2>
      {if $failed}
      <p>Login failed. Please check your login information again.</p>
      {/if}
      <form action="{$baselink}Login/?action=submit" method="POST">
        <table>
          <tr><td><label for="username">Username</label></td><td><input id="username" name="username" value="" /></td></tr>
          <tr><td><label for="password">Password</label></td><td><input id="password" name="password" type="password" /></td></tr>
        </table>
        <input type="submit" value="OK">
      </form>
    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
