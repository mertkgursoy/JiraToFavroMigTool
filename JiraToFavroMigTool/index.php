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

  <input type="file" id="the-file-input" /><div id="theContainer"></div>
  <iframe id="theTaskIframe" src="/jiratofavromigtool/task.php" width="100%" height="1900" style="border:1px solid black;">
  </iframe>

  <script>

  console.log("Author: MertKGursoy");

  function theReader(e) {
    var file = e.target.files[0];
    if (!file) {
      return;
    }
    var reader = new FileReader();
    reader.onload = function(e) {
      var cont = e.target.result;
      theParsed(cont);
    };
    reader.readAsText(file);
  }
  function theParsed(cont) {
   const json = cont.split(",(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)");
    var theText = JSON.stringify(json);
    theText = theText.replace(/\[/g, "");
    theText = theText.replace(/\]/g, "");
    theText = theText.replace(/\\n/g, "");
    theText = theText.replace(/\\r/g, '", "');
    theText = theText.replace(/\\/g, '"');
    var str = theText;
    var str_array = str.match(/(".*?"|[^",\s]+)(?=\s*,|\s*$)/g);

    var theLength = str_array.length + 1;
    for(var i = 0; i < theLength ; i++) {
              delay(i);
    }
    function delay (i) {



          setTimeout(() => {
              str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
              var jiraIssueIds = str_array[i];
              var jiraIssueIdsNoQuotes = jiraIssueIds.replace(/['"]+/g, '');

              // console.log(jiraIssueIdsNoQuotes);

              if (jiraIssueIdsNoQuotes) {

                function theTaskIframeUpdate(){
                  $('#theTaskIframe').attr('src', "http://localhost:8888/jiratofavromigtool/task.php?taskid=" + jiraIssueIdsNoQuotes);
                }
                theTaskIframeUpdate();

              } else {

              }


          },i * 3000);


   }
  }
  document.getElementById('the-file-input').addEventListener('change', theReader, false);


  </script>








</body>
</html>
