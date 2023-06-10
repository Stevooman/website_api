[![codecov](https://codecov.io/gh/Stevooman/website_api/branch/main/graph/badge.svg?token=09KFLSPU6Q)](https://codecov.io/gh/Stevooman/website_api)
# website_api
Backend for my personal website built in Laravel 10

<h2>Structure</h2><br>
<p>The project structure consists of:</p>
  <ul>
    <li>Models: Contain the business logic of the application, interacting with the database.</li>
    <li>Requests: Custom request classes used for validating user input, effectively separating business and application logic.</li>
    <li>Controllers: Accept the user input and returns formatted data back to the client.</li>
  </ul><br><br>
<p>You may notice there are no custom view classes within this project. This is because the frontend is built in Vue.js.</p>


