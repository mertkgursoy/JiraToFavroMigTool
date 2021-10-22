<!DOCTYPE html>
<html>
<head>
  <title> Jira To Favro Mig Tool </title>
  <!--===============================================================================================-->
  <meta name="author" content="MertKGursoy">
  <!--===============================================================================================-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!--===============================================================================================-->
  <meta charset="utf-8">
  <!--===============================================================================================-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!--===============================================================================================-->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <!--===============================================================================================-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<br>
<p> Task To Favro Php </p>
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
if(isset($_GET['taskid'])) {
    // echo $_GET['taskid'];
    $theTaskIdInPhp = $_GET['taskid'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://YourJiraDomainName.atlassian.net/rest/api/3/issue/' . $theTaskIdInPhp,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic (YouCanGetItFromPostman)',
        'Cookie: (YouCanGetItFromPostman)'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;


    if ($response) {
      // Json Repsonse
      $jsonResponse = json_decode($response, true);
      // Issue Key
      $jsonResponseKey = "";
      if (isset($jsonResponse['key'])) {
        $jsonResponseKey = $jsonResponse['key'];
      } else {
        $jsonResponseKey = "none";
      }
      echo "Task Key: " . $jsonResponseKey . "<br><br>";
      // Issue Type Name
      $issueTypeName = "";
      if (isset($jsonResponse['fields']['issuetype']['name'])) {
        $issueTypeName = $jsonResponse['fields']['issuetype']['name'];
      } else {
        $issueTypeName = "none";
      }
      echo "Task Type: " . $issueTypeName . "<br><br>";

      // Parent Values
      $parentKey = "";
      if (isset($jsonResponse['fields']['parent']['key'])) {
        $parentKey = $jsonResponse['fields']['parent']['key'];
      } else {
        $parentKey = "none";
      }
      // Parent Values
      $parentFieldsSummary = "";
      if (isset($jsonResponse['fields']['parent']['fields']['summary'])) {
        $parentFieldsSummary = $jsonResponse['fields']['parent']['fields']['summary'];
      } else {
        $parentFieldsSummary = "none";
      }
      $parentIssueTextValue = $parentFieldsSummary . "-" . $parentKey;
      echo "ParentKey: " . $parentIssueTextValue . "<br><br>";

      // Issue Summary
      $issueSummaryTexti = "";
      if (isset($jsonResponse['fields']['summary'])) {
        $issueSummaryTexti = $jsonResponse['fields']['summary'];
      } else {
        $issueSummaryTexti = "none";
      }
      $issueSummaryText11 = str_replace(':','-', $issueSummaryTexti);
      $issueSummaryText = preg_replace('/[^\p{L}\p{N} ]+/', '', $issueSummaryText11);
      echo "Title/Summary: " . $issueSummaryText . "<br><br>";

      // Assignee  Value
      $assigneeValue = "";
      if (isset($jsonResponse['fields']['assignee']['displayName'])) {
        $assigneeValue1 = $jsonResponse['fields']['assignee']['displayName'];
        $assigneeValue = preg_replace('/[^\p{L}\p{N} ]+/', '', $assigneeValue1);
      } else {
        $assigneeValue = "none";
      }
      echo "Assignee: " . $assigneeValue . "<br><br>";

      // Reporter  Value
      $reporterValue = "";
      if (isset($jsonResponse['fields']['reporter']['displayName'])) {
        $reporterValue1 = $jsonResponse['fields']['reporter']['displayName'];
        $reporterValue = preg_replace('/[^\p{L}\p{N} ]+/', '', $reporterValue1);
      } else {
        $reporterValue = "none";
      }
      echo "Reporter: " . $reporterValue . "<br><br>";

      // Custom Field Value
      $conValue = "";
      if (isset($jsonResponse['fields']['customfield_YOURCUSTOMFIELDID']['content'][0]['content'][0]['text'])) {
        $conValue1 = $jsonResponse['fields']['customfield_YOURCUSTOMFIELDID']['content'][0]['content'][0]['text'];
        $conValue = preg_replace('/[^\p{L}\p{N} ]+/', '', $conValue1);
      } else {
        $conValue = "none";
      }
      echo "Custom Field Value: " . $conValue . "<br><br>";

      // Labels Array Value
      $labelsArray = "";
      if (isset($jsonResponse['fields']['labels'])) {
        $labelsArray1 = $jsonResponse['fields']['labels'];
        $labelsArray = preg_replace('/[^\p{L}\p{N} ]+/', '', $labelsArray1);
      } else {
        $labelsArray = "none";
      }
      $theLabelsTextString = implode("-", $labelsArray);
      echo "Labels: " . $theLabelsTextString . "<br><br>";

      // Issue Link Array Value
      $theLinkedIssueArray = array();
      $linkedIssuesArrayJson = "";
      if (isset($jsonResponse['fields']['issuelinks'])) {
        $linkedIssuesArrayJson = $jsonResponse['fields']['issuelinks'];
        foreach ($linkedIssuesArrayJson as $key => $vallaaaaa) :
            $linkedIssuesArrayVall = $vallaaaaa;
            if(isset($vallaaaaa['type']['outward']))  {
             $linkedIssueType = $vallaaaaa['type']['outward'];
           } else {
             $linkedIssueType = "none";
           }
           if(isset($vallaaaaa['outwardIssue']['key']))  {
             $linkedIssueKey = $vallaaaaa['outwardIssue']['key'];
           } else {
             $linkedIssueKey = "none";
           }
           if(isset($vallaaaaa['outwardIssue']['fields']['summary']))  {
             $linkedIssueTitle1 = $vallaaaaa['outwardIssue']['fields']['summary'];
             $linkedIssueTitle = preg_replace('/[^\p{L}\p{N} ]+/', '', $linkedIssueTitle1);
             $theFullLinkedIssues = $linkedIssueType . "---" . $linkedIssueKey . "---" . $linkedIssueTitle;
             array_push($theLinkedIssueArray,$theFullLinkedIssues);
           } else {
             $theFullLinkedIssues = "none";
             array_push($theLinkedIssueArray,$theFullLinkedIssues);
           }
        endforeach;
      } else {
        $theLinkedIssueArray = "none";
      }
      $theLinkedIssueArrayStrt = implode("-", $theLinkedIssueArray);
      // echo "Linked Issues: " . $theLinkedIssueArrayStrt . "<br><br>";

      // Description Array Value
      $theDescriptionArray = array();
      $theDescriptionArrayContentArray = "";
      if (isset($jsonResponse['fields']['description']['content'])) {
            $theDescriptionArrayContentArray = $jsonResponse['fields']['description']['content'];
            foreach ($theDescriptionArrayContentArray as $key => $vallaa) :
                    $theDescriptionValContent = $vallaa;
                            foreach ($theDescriptionValContent['content'] as $theekey => $valueeii) :
                                         if(isset($valueeii['text']))  {
                                           $theFullDescription1 = $valueeii['text'];
                                           $theFullDescription = preg_replace('/[^\p{L}\p{N} ]+/', '', $theFullDescription1);
                                           $theFullDescription = "-". $theFullDescription . "-";
                                           array_push($theDescriptionArray,$theFullDescription);
                                         } else {
                                           $theFullDescription = "none";
                                           array_push($theDescriptionArray,$theFullDescription);
                                         }
                                         if(isset($valueeii['content']))  {
                                         $theParagraphArrayVal = $valueeii['content'];
                                         foreach ($theParagraphArrayVal as $theekey11 => $valueeii111111) :
                                                      if(isset($valueeii111111['content'][0]))  {
                                                        $theParagraphArrayValContent = $valueeii111111['content'][0];
                                                                          if(isset($theParagraphArrayValContent['content'][0]))  {
                                                                                $theParagraphArrayValContent2 = $theParagraphArrayValContent['content'][0];
                                                                                if(isset($theParagraphArrayValContent2['text']))  {
                                                                                $parValleeeee2 = $theParagraphArrayValContent2['text'];
                                                                                $parValleeeee = preg_replace('/[^\p{L}\p{N} ]+/', '', $parValleeeee2);
                                                                                $parValleeeee = "-". $parValleeeee . "-";
                                                                                array_push($theDescriptionArray,$parValleeeee);
                                                                                } else {
                                                                                  $parValleeeee = "none";
                                                                                  array_push($theDescriptionArray,$parValleeeee);
                                                                                }
                                                                          } else {
                                                                            echo " ";
                                                                          }
                                                      } else {
                                                        echo " ";
                                                      }
                                         endforeach;
                                       } else {
                                         echo " ";
                                       }
                            endforeach;
            endforeach;
      } else {
        $theDescriptionArray = "none";
      }
      $theDescriptionArrayString0 = implode("-----", $theDescriptionArray);
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
      $theDescriptionArrayString = str_replace('>','-', $theDescriptionArrayString11);
      echo "Description: " . $theDescriptionArrayString . "<br><br>";

      // Comment Array Value
      $theCommentsOfTheTasksArray = array();
      $jsonResponseCommentTextArray = "";
      if (isset($jsonResponse['fields']['comment']['comments'])) {
              $jsonResponseCommentTextArray = $jsonResponse['fields']['comment']['comments'];
              foreach ($jsonResponseCommentTextArray as $key => $val) :
                      $theCommentOwnerName1 = $val['author']['displayName'];
                      $theCommentOwnerName = preg_replace('/[^\p{L}\p{N} ]+/', '', $theCommentOwnerName1);
                      $theCommenOwnerCreatedAt1 = $val['created'];
                      $theCommenOwnerCreatedAt = preg_replace('/[^\p{L}\p{N} ]+/', '', $theCommenOwnerCreatedAt1);
                      $theCommentBodyArray = $val['body']['content'];
                      foreach ($theCommentBodyArray as $key => $valuee) :
                        if(isset($valuee['content'][0]['text']))  {
                          $theCommentTxttt1 = $valuee['content'][0]['text'];
                          $theCommentTxttt = preg_replace('/[^\p{L}\p{N} ]+/', '', $theCommentTxttt1);
                          // echo $theCommentTxttt;
                          // echo "<br><br>";
                          $theFullComment = "The Comment Owner--" . $theCommentOwnerName . "  The Comment Date--" .$theCommenOwnerCreatedAt . " The Comment Text--" . $theCommentTxttt;
                          //echo $theFullComment . "<br><br>";
                          array_push($theCommentsOfTheTasksArray,$theFullComment);
                        } else {
                          $theFullComment = "none";
                          //echo $theFullComment . "<br><br>";
                          array_push($theCommentsOfTheTasksArray,$theFullComment);
                        }
                      endforeach;
              endforeach;
      } else {
        $theCommentsOfTheTasksArray = "none";
      }
      $theCommentsOfTheTasksArrayString1 = implode("------", $theCommentsOfTheTasksArray);
      $theCommentsOfTheTasksArrayString = "-----" . $theCommentsOfTheTasksArrayString1 . "-----";
      // echo "Comments: " . $theCommentsOfTheTasksArrayString . "<br><br>";
          // Task Key var ise //
          if ($jsonResponseKey) {
            $theTitle = $issueTypeName . " - " .  $issueSummaryText . " - " . $jsonResponseKey;
            $theDescAndComment = "Description: " . $theDescriptionArrayString . "Comments: " . $theCommentsOfTheTasksArrayString;
                        if ($issueTypeName === "Task" || $issueTypeName === "Subtask") {
                          $curl = curl_init();
                          curl_setopt_array($curl, array(
                            CURLOPT_SSL_VERIFYPEER => 0,
                            CURLOPT_URL => 'https://favro.com/api/v1/cards',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS =>"{\n
                                  \"name\": \"$theTitle\",\n
                                  \"widgetCommonId\":\"(YourFavroWidgetId)\",\n
                                  \"detailedDescription\": \"$theDescAndComment\",\n
                                  \"customFields\": [\n
                                        {\n
                                            \"customFieldId\":\"YourCustomFieldId\",\n
                                            \"value\": \"$YourCustomFieldVariable\"\n
                                        },\n
                                        {\n
                                            \"customFieldId\":\"(YourCustomFieldId)\",\n
                                            \"value\": \"$YourCustomFieldVariable\"\n
                                        }\n
                                  ]\n
                            }",
                            CURLOPT_HTTPHEADER => array(
                              'organizationId: (YourFavroOrganizationId)',
                              'Content-Type: application/json',
                              'Authorization: Basic (YouCanGetItFromPostman)',
                              'Cookie: (YouCanGetItFromPostman)'
                            ),
                          ));
                          $response = curl_exec($curl);
                          curl_close($curl);
                          echo $response;
                          //echo "<br>the issue type: " . $issueTypeName;
                          echo "The Ticket Has Been Created!";
                        } else {
                          //echo "<br>the issue type: " . $issueTypeName;
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
