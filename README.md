[![codecov](https://codecov.io/gh/Stevooman/website_api/branch/main/graph/badge.svg?token=09KFLSPU6Q)](https://codecov.io/gh/Stevooman/website_api)
# website_api
Backend for my personal project website built in Laravel 10

<h2>Structure</h2><br>
<p>The project structure consists of:</p>
  <ul>
    <li>Models: Contain the business logic of the application, interacting with the database.</li>
    <li>Requests: Custom request classes used for validating user input, effectively separating business and application logic.</li>
    <li>Controllers: Accept the user input and returns formatted data back to the client.</li>
  </ul><br><br>
<h2>APIs and Their Methods</h2>
  <p>The following API's and their individual endpoints are available for use in this project:</p><br>
  
  <h4>Companies</h4><br>
  <p>This project contains a database migration for a table called 'companies'. It contains info for gaming companies.</p>
    <ul>
      <li><b>GET</b> - Show all companies registered in the database.</li>
      <li><b>GET</b> - Show all companies currently active.</li>
      <li><b>GET</b> - Show one company info based on an ID.</li>
      <li><b>POST</b> - Create a new company record.</li>
      <li><b>PUT</b> - Update an existing record.</li>
      <li><b>DELETE</b> - Soft delete a record.</li>
    </ul><br>

  <h4>Systems</h4><br>
  <p>The 'systems' table contains info on gaming systems created by gaming companies.</p>
    <ul>
      <li><b>GET</b> - Show all systems registered in the database.</li>
      <li><b>GET</b> - Show one system info based on an ID.</li>
      <li><b>GET</b> - Show systems released between a given date range.</li>
      <li><b>POST</b> - Create a new system record.</li>
      <li><b>PUT</b> - Update an existing record.</li>
      <li><b>DELETE</b> - Soft delete a record.</li>
    </ul><br>

  <h4>Users</h4><br>
  <p>'users' contains data for an individual who creates an account on our website, including email, username, and password. Passwords are hashed before being stored in the table, and any login attempts verify the username and hashed password with the PHP 'password_verify' function.</p>
    <ul>
      <li><b>GET</b> - Show data for all users.</li>
      <li><b>GET</b> - Show one user info based on an ID.</li>
      <li><b>GET</b> - Show one user info based on a valid username and password.</li>
      <li><b>POST</b> - Create a new user record.</li>
      <li><b>PUT</b> - Update a user's password.</li>
      <li><b>PUT</b> - Update a user's email.</li>
      <li><b>PUT</b> - Update a user's username.</li>
      <li><b>DELETE</b> - Soft delete a record.</li>
    </ul><br>

  <h4>Zelda Users</h4><br>
  <p>'zelda_users' contains data for users that have registered certain Zelda games as a game that they're currently playing or have played in the past.</p>
    <ul>
      <li><b>GET</b> - Show one Zelda User info based on an ID.</li>
      <li><b>POST</b> - Create a new Zelda user record.</li>
      <li><b>DELETE</b> - Soft delete a record.</li>
    </ul>
