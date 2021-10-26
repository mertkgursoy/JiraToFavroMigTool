# JiraToFavroMigTool
How to migrate the Jira issues dynamically from Jira to a new “Product Management Tool” | Jira Rest API & Favro Rest API Postman & PHP

1. Export the tasks that we want to migrate from Jira to Favro as a csv file via Jira Advanced Search
  * Select “Filter > Advanced Search”
  * Then create your query and select only “KEY” column and below
  * And download / export it as a CSV File (Export Excel CSV (current fields)
  * Delete “Issue id column” and “issue key row” the it should be like this below.

2. Getting Jira API Token & Creating Jira Rest API Get Request via Postman (for each task)
  * Jira Rest Api CURL request is needed. (GET)
  * You can check the following steps in the link to get this CURL request.
  * How to create a task / an issue via Jira Rest API and Postman
  * Getting Jira API Token
  * Getting Favro API Token & Creating Favro Rest API Post Request via Postman (for each task). You need to have it from “My Profile > API Tokens > Create new token” and save it.

3. Create your own Favro Post CURL request to create a ticket in favro.
  * Authorization
  * Username :Your Favro Account Email
  * Password: Your Favro API Token

  * Organization Id
  * organziationId: Your Favro Organization Id
  * Content-Type: application/json

  * And then get the CURL Post Request from Postman

4. Creating taskMigrate.php file to create a task in Favro
  * Now we are able to use these both CURL requests in the code below to migrate our Jira tasks to Favro. To do that we need to create this page.

5. Creating index.php file to create a task in Favro from the csv spreadsheet file.
  * To create the tasks in favro from the csv spreadsheet file (that we created in the first step), we need to create this page.
