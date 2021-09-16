<!DOCTYPE html>
<html>
<head>
  <title> JF_Mig_Tool </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>


<body>


<br>

<h1> Mert Kadir Gursoy - Jira To Favro Migration Tool </h1>




<script>



  var theUrlAddressValue= location.href;
  var theUrlAddressValueConverted= theUrlAddressValue.toLowerCase();

  if(theUrlAddressValueConverted.indexOf('taskid') != -1)
  {
      // alert("url has taskid");

      var theTaskIdValue = theUrlAddressValue.substr ( theUrlAddressValue.indexOf ( '=' ) + 1 );
      // alert(theTaskIdValue);


  }
  else
  {
      // alert("url has no taskid");
  }


</script>






<?php


// Add your Jira Rest Api  UserName And Token Hashed Value ( You can get them easily from code of Postman ) (READ READ ME)
$yourJiraRestApiUserNameAndTokenHashed = "Add Here!"
// Add your Jira Rest Api  Cookie Token ( You can get them easily from code of Postman ) (READ READ ME)
$yourJiraRestApiAtlassianToken = "Add Here!"
// Add your Jira Project Key (READ READ ME)
$youJiraProjectKey = "Add Here!";


// Add your Favro Rest Api  UserName And Token Hashed Value ( You can get them easily from code of Postman ) (READ READ ME)
$yourFavroRestApiUserNameAndTokenHashed = "Add Here!"
// Add your Favro Rest Api  Cookie Token ( You can get them easily from code of Postman ) (READ READ ME)
$yourFavroCookie = "Add Here!"
// Add your Favro Organization Id ) (READ READ ME)
$favroOrganizationId = "Add Here!"
// Add your Favro Widget Id ) (READ READ ME)
$favroWidgetId = "Add Here!"


if(isset($_GET['taskid'])) {
    // echo $_GET['taskid'];

    $theTaskIdInPhp = $_GET['taskid'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://'. $youJiraProjectKey .'.atlassian.net/rest/api/3/issue/' . $theTaskIdInPhp,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic  ' . $yourJiraRestApiUserNameAndTokenHashed,
        'Cookie: atlassian.xsrf.token='. $yourJiraRestApiAtlassianToken
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;


    if ($response) {

      $jsonResponse = json_decode($response, true);

      // Issue Key
      $jsonResponseKey = $jsonResponse['key'];
      // echo $jsonResponseKey;

      // Issue Type
      $issueTypeId = $jsonResponse['fields']['issuetype']['id'];
      //echo $issueTypeId;

      // Issue Type Name
      $issueTypeName = $jsonResponse['fields']['issuetype']['name'];
      //echo $issueTypeName;

      // Issue Summary
      $issueSummaryTexti = $jsonResponse['fields']['summary'];
      $issueSummaryText11 = str_replace(':','-', $issueSummaryTexti);
      $issueSummaryText = preg_replace('/[^\p{L}\p{N} ]+/', '', $issueSummaryText11);
      // echo $issueSummaryText;


      // Story Point Value
      $storyPointValue = $jsonResponse['fields']['customfield_10056'];
      // echo $storyPointValue;

      // Priority  Value
      $priorityValue = $jsonResponse['fields']['priority']['name'];
      // echo $priorityValue;

      // Assignee  Value
      $assigneeValue = $jsonResponse['fields']['assignee']['displayName'];
      // echo $assigneeValue;


      // Reporter  Value
      $reporterValue = $jsonResponse['fields']['reporter']['displayName'];
      // echo $reporterValue;



      // Confluence Value
      // $confValue = $jsonResponse['fields']['customfield_10139']['content'][0]['content'][0]['text'];
      // echo $confValue;

      // Environment Value
      $envrrrExist = $jsonResponse['fields']['environment'];
      $tenvrrArray = array();
      if(isset($envrrrExist))  {
        $environmentValueArray = $jsonResponse['fields']['environment']['content'][0]['content'];
          foreach ($environmentValueArray as $keeey => $vallaaaa) :
              if(isset($vallaaaa['text']))  {
                $environmentValueChecked = $vallaaaa['text'];
                array_push($tenvrrArray,$environmentValueChecked);
              } else {
                // echo  "environment yok" ;
              }
          endforeach;

        // echo "var";

      } else {

        // echo "yok";
      }
      // $envrrrArrayStrVal = implode("-", $tenvrrArray);
      // echo $envrrrArrayStrVal;







      // Issue Link Array Value
      $theLinkedIssueArray = array();
      $linkedIssuesArrayJson = $jsonResponse['fields']['issuelinks'];
      foreach ($linkedIssuesArrayJson as $key => $vallaaaaa) :
              $linkedIssuesArrayVall = $vallaaaaa;


              if(isset($vallaaaaa['type']['outward']))  {
               $linkedIssueType = $vallaaaaa['type']['outward'];

             } else {
               echo " ";
             }
             if(isset($vallaaaaa['outwardIssue']['key']))  {
               $linkedIssueKey = $vallaaaaa['outwardIssue']['key'];
             } else {
               echo " ";
             }


             if(isset($vallaaaaa['outwardIssue']['fields']['summary']))  {
               $linkedIssueTitle = $vallaaaaa['outwardIssue']['fields']['summary'];


               $theFullLinkedIssues = $linkedIssueType . "=> " . $linkedIssueKey . " - " . $linkedIssueTitle;
               array_push($theLinkedIssueArray,$theFullLinkedIssues);

             } else {
               echo " ";
             }



      endforeach;
      $theLinkedIssueArrayStrt = implode("&&", $theLinkedIssueArray);
      // echo $theLinkedIssueArrayStrt;



      // Description Array Value
      $theDescriptionArray = array();
      $theDescriptionArrayContentArray = $jsonResponse['fields']['description']['content'];
      foreach ($theDescriptionArrayContentArray as $key => $vallaa) :
              $theDescriptionValContent = $vallaa;
              // print_r($theDescriptionValContent  );
              foreach ($theDescriptionValContent['content'] as $theekey => $valueeii) :
                           if(isset($valueeii['text']))  {
                             $theFullDescription = $valueeii['text'];
                             array_push($theDescriptionArray,$theFullDescription);
                           } else {
                             echo " ";
                           }
              endforeach;
      endforeach;
      $theDescriptionArrayString0 = implode("****", $theDescriptionArray);
      $theDescriptionArrayString1 = str_replace(':','-', $theDescriptionArrayString0);
      $theDescriptionArrayString2 = str_replace('{','-', $theDescriptionArrayString1);
      $theDescriptionArrayString3 = str_replace('}','-', $theDescriptionArrayString2);
      $theDescriptionArrayString4 = str_replace('[','-', $theDescriptionArrayString3);
      $theDescriptionArrayString5 = str_replace(']','-', $theDescriptionArrayString4);
      $theDescriptionArrayString6 = str_replace('=','-', $theDescriptionArrayString5);
      $theDescriptionArrayString7 = str_replace(',','-', $theDescriptionArrayString6);
      $theDescriptionArrayString8 = str_replace('+','-', $theDescriptionArrayString7);
      $theDescriptionArrayString9 = str_replace('"','-', $theDescriptionArrayString8);
      $theDescriptionArrayString10 = str_replace('@','-', $theDescriptionArrayString9);
      $theDescriptionArrayString11 = str_replace('<','-', $theDescriptionArrayString10);
      $theDescriptionArrayString12 = str_replace('>','-', $theDescriptionArrayString11);




      $theDescriptionArrayString = preg_replace('/[^\p{L}\p{N} ]+/', '', $theDescriptionArrayString12);

      // echo $theDescriptionArrayString;

      // echo $theDescriptionArrayString;


      // Provider Array Value
      if(isset($jsonResponse['fields']['customfield_10138']))  {
        $providerArray = $jsonResponse['fields']['customfield_10138'];
        $theProviderTextString = implode(",", $providerArray);
      } else {
        echo " ";
      }

      // echo $theProviderTextString;

      // Labels Array Value
      $labelsArray = $jsonResponse['fields']['labels'];
      $theLabelsTextString = implode(",", $labelsArray);
      // echo $theLabelsTextString;


      // Comment Array Value
      $theCommentsOfTheTasksArray = array();
      $jsonResponseCommentName = $jsonResponse['fields']['comment']['comments'];
      $jsonResponseCommentTextArray = $jsonResponse['fields']['comment']['comments'];
      foreach ($jsonResponseCommentTextArray as $key => $val) :

              $theCommentOwnerName = $val['author']['displayName'];
              $theCommenOwnerCreatedAt = $val['created'];

              $theCommentBodyArray = $val['body']['content'];
              foreach ($theCommentBodyArray as $key => $valuee) :



                if(isset($valuee['content'][0]['text']))  {


                  $theCommentTxttt = $valuee['content'][0]['text'];
                  // echo $theCommentTxttt;
                  // echo "<br><br>";

                  $theFullComment = "The Comment Owner: " . $theCommentOwnerName . "  The Comment Date: " .$theCommenOwnerCreatedAt . " The Comment Text: " . $theCommentTxttt;

                  //echo $theFullComment . "<br><br>";

                  array_push($theCommentsOfTheTasksArray,$theFullComment);


                } else {
                  echo " ";
                }





              endforeach;
      endforeach;
      $theCommentsOfTheTasksArrayString1 = implode("*****", $theCommentsOfTheTasksArray);
      $theCommentsOfTheTasksArrayString = preg_replace('/[^\p{L}\p{N} ]+/', '', $theCommentsOfTheTasksArrayString1);

      // echo $theCommentsOfTheTasksArrayString;





          // Task Key var ise //
          if ($jsonResponseKey) {

            //echo "<p>" . $jsonResponseKey . "</p> <br>";


            $theAllDataComment = "(Jira Task ID: " . $jsonResponseKey . ") >>>>>>>" . " (Issue Type: " . $issueTypeName . ") >>>>>>> " . "( Assignee: " . $assigneeValue . ") >>>>>>>" . "( Task Title: " . $issueSummaryText . ") >>>>>>>" . "( Description: " . $theDescriptionArrayString . ") >>>>>>> " . "( Story Point: " . $storyPointValue . ") >>>>>>>" . "( Priority: " . $priorityValue . ") >>>>>>>" . "( Reporter: " . $reporterValue . ") >>>>>>> " . " ( Linked Issues: " . $theLinkedIssueArrayStrt . ") >>>>>>> " . "( Proivders: " . $theProviderTextString . ") >>>>>>> " . "( Comment of Task: " . $theCommentsOfTheTasksArrayString . ")";

            $theTaskTitleFull = "" . $issueTypeName . " - " .  $issueSummaryText . " - " . "" . $jsonResponseKey . " - (" . "Assignee: " . $assigneeValue . " " . " - " . "Providers: " . $theProviderTextString . "" . ")";

            // echo $theAllDataComment;


            if ($issueTypeName === "Sub-task") {
              // Parent Values
              $parentKey = $jsonResponse['fields']['parent']['key'];
              $parentFieldsSummary = $jsonResponse['fields']['parent']['fields']['summary'];
              $parentIssueTextValue = $parentFieldsSummary . " - " . $parentKey;
              // echo $parentIssueTextValue;


              // Fpr Sub Task And Sub Bug
              $theAllDataCommentForSubTaskandSubBug = "(Jira Task ID: " . $jsonResponseKey . ") >>>>>>>" . " (Issue Type: " . $issueTypeName . ") >>>>>>> " . "( Assignee: " . $assigneeValue . ") >>>>>>>" . "( Task Title: " . $issueSummaryText . ") >>>>>>>" . "( Description: " . $theDescriptionArrayString . ") >>>>>>> " . "( Story Point: " . $storyPointValue . ") >>>>>>>" . "( Priority: " . $priorityValue . ") >>>>>>>" . "( Reporter: " . $reporterValue . ") >>>>>>> " . "( Parent Task: " .  $parentIssueTextValue  . ") >>>>>>> " . " ( Linked Issues: " . $theLinkedIssueArrayStrt . ") >>>>>>> " . "( Proivders: " . $theProviderTextString . ") >>>>>>> " . "( Comment of Task: " . $theCommentsOfTheTasksArrayString . ")";



              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://favro.com/api/v1/cards',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{\n

                      \"name\": \"$theTaskTitleFull\",\n
                      \"widgetCommonId\":\"". $favroWidgetId . "\",\n
                      \"detailedDescription\": \"$theAllDataCommentForSubTaskandSubBug\"\n
                }",



                CURLOPT_HTTPHEADER => array(
                  'organizationId: ' . $favroOrganizationId,
                  'Content-Type: application/json',
                  'Authorization: Basic ' $yourFavroRestApiUserNameAndTokenHashed,
                  'Cookie: ' $yourFavroCookie
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);
              echo $response;




              // echo "SUB TASK HERE";


            } else if ($issueTypeName === "Sub-bug"){

              // Parent Values
              $parentKey = $jsonResponse['fields']['parent']['key'];
              $parentFieldsSummary = $jsonResponse['fields']['parent']['fields']['summary'];
              $parentIssueTextValue = $parentFieldsSummary . " - " . $parentKey;
              // echo $parentIssueTextValue;


              // Fpr Sub Task And Sub Bug
              $theAllDataCommentForSubTaskandSubBug = "(Jira Task ID: " . $jsonResponseKey . ") >>>>>>>" . " (Issue Type: " . $issueTypeName . ") >>>>>>> " . "( Assignee: " . $assigneeValue . ") >>>>>>>" . "( Task Title: " . $issueSummaryText . ") >>>>>>>" . "( Description: " . $theDescriptionArrayString . ") >>>>>>> " . "( Story Point: " . $storyPointValue . ") >>>>>>>" . "( Priority: " . $priorityValue . ") >>>>>>>" . "( Reporter: " . $reporterValue . ") >>>>>>> " . "( Parent Task: " .  $parentIssueTextValue  . " ) >>>>>>> " . " ( Linked Issues: " . $theLinkedIssueArrayStrt . ") >>>>>>> " . "( Proivders: " . $theProviderTextString . ") >>>>>>> " . "( Comment of Task: " . $theCommentsOfTheTasksArrayString . ")";



              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://favro.com/api/v1/cards',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{\n

                      \"name\": \"$theTaskTitleFull\",\n
                      \"widgetCommonId\":\"". $favroWidgetId . "\",\n
                      \"detailedDescription\": \"$theAllDataCommentForSubTaskandSubBug\"\n
                }",



                CURLOPT_HTTPHEADER => array(
                  'organizationId: ' $favroOrganizationId,
                  'Content-Type: application/json',
                  'Authorization: Basic ' $yourFavroRestApiUserNameAndTokenHashed,
                  'Cookie: ' $yourFavroCookie
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);
              echo $response;






              // echo "SUB BUG HERE";



            } else if ($issueTypeName === "Task") {

              // echo "TASK HERE";





              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://favro.com/api/v1/cards',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{\n

                      \"name\": \"$theTaskTitleFull\",\n
                      \"widgetCommonId\":\"". $favroWidgetId . "\",\n
                      \"detailedDescription\": \"$theAllDataComment\"\n
                }",



                CURLOPT_HTTPHEADER => array(
                  'organizationId: ' $favroOrganizationId,
                  'Content-Type: application/json',
                  'Authorization: Basic ' . $yourFavroRestApiUserNameAndTokenHashed,
                  'Cookie: ' $yourFavroCookie
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);
              echo $response;












            } else if ($issueTypeName === "Bug")  {



              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://favro.com/api/v1/cards',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{\n

                  \"name\": \"$theTaskTitleFull\",\n
                  \"widgetCommonId\":\"". $favroWidgetId . "\",\n
                  \"detailedDescription\": \"$theAllDataCommentForSubTaskandSubBug\"\n
            }",



                CURLOPT_HTTPHEADER => array(
                  'organizationId: ' $favroOrganizationId,
                  'Content-Type: application/json',
                  'Authorization: Basic ' . $yourFavroRestApiUserNameAndTokenHashed,
                  'Cookie: ' . $yourFavroCookie
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);
              echo $response;









              // echo "BUG HERE";


            } else {
              // echo "task type does not exist.";
            }

          // Task oluşmamış ise //
          } else {

            $strResponse = (string) $response;
            echo "<script> alert  ('Issue Key Does Not Exist Error. Please inform tech team. $strResponse ')</script>";

          }


    } else {
      echo "<script> console.log  ('Response Does Not Exist Error. Please inform tech team.  ')</script>";

    }



} else {
    echo "No Task Id Exists";
}

?>





</body>
</html>
