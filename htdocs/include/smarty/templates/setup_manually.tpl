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
      <h2>Setup (Manually)</h2>
      {include file='sub_menu.tpl' baselink=$baselink main_item='Setup' items=$sub_menu_items selected=$sub_selected}

      <div id="main_area">
        <p>Please follow the these steps to set up the database to set up OPDS Courses:</p>
        <ul id="manually_setup_list">
          <li>Create a new empty database, feel free to select a name you want. Please note: OPDS Courses supports the use of <strong>table prefixes</strong> so you can use existing databases. The problem however is, in this mode you have to import a <strong>static sql file</strong>. If you want to use table prefixes the <a href="{$baselink}Setup/Automatic">automatic mode</a> might be the better choice for you. Alernatively you could edit the SQL file after downloading manually of course to enter the prefixes on your own.</li>
          <li>Download the <strong>empty</strong> <a href="{$baselink}res/setup/opds_courses_latest_empty.sql">latest SQL export</a>. If you want to start with some <strong>sample data</strong> use the <a href="{$baselink}res/setup/opds_courses_latest_sample.sql">latest sample SQL export</a> instead. Import the SQL file into the database.
          <li>You can either use an existing database user or reuse an existing one. However it is recommended to limit this user's <strong>permissions</strong> to the new database tables (SELECT, INSERT, UPDATE, DELETE)</li>
          <li>
            <div>Enter your data in JSON format into the file opds_courses/include/config/db.config</div>
            <div>These are the fields you have to fill in (with example data):</div>
            <ul>
              <li>"host":"localhost"</li>
              <li>"user":"opds_courses"</li>
              <li>"enc_password":"cGFzc3dvcmQ="</li>
              <li>"database":"opds_courses"</li>
              <li>"table_prefix":""</li>
            </ul>
            <div>Please node: The password is encoded using <strong>base64</strong>.</div>
          </li>
          <li>Test the connection!</li>
        </ul>

        <form action="{$baselink}Setup/Test" method="get">
          <input id="test_connection_button" type="submit" value="Test it!" />
        </form>

      </div>

    </div>
    {include file='footer.tpl' baselink=$baselink}
    <link rel="stylesheet" property="stylesheet" type="text/css" href="{$baselink}css/content/setup_manually.css" />
  </body>
</html>
