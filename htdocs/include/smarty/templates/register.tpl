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
      <h2>Register</h2>
      <form action="{$baselink}Register/?action=submit" method="POST">
        <table>
          <tr><td><label for="username">Username</label></td><td><input id="username" name="username" /></td></tr>
          <tr><td><label for="password">Password</label></td><td><input id="password" name="password" type="password" /></td></tr>
          <tr><td><label for="title">Title</label></td><td><input id="title" name="title" /></td></tr>
          <tr><td><label for="first_name">First name</label></td><td><input id="first_name" name="first_name" /></td></tr>
          <tr><td><label for="last_name">Last name</label></td><td><input id="last_name" name="last_name" /></td></tr>
        </table>
        <input type="submit" value="OK">
      </form>
    </div>
    {include file='footer.tpl' baselink=$baselink}
  </body>
</html>
