<?php
// multiple recipients
$to  = 'johnathana@gmail.com';

// message
$message = '
<html>
<head>
  <title>Δημιουργία λογαριασμού</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Additional headers
$headers .= 'To: johnathana@gmail.com' . "\r\n";
$headers .= 'From: ODT UOA workoffer <webmaster@di.uoa.gr>' . "\r\n";
$headers .= 'Cc:  ' . "\r\n";
$headers .= 'Bcc: ' . "\r\n";
$headers .= 'Subject: Δημιουργία λογαριασμού'. "\r\n";

// Mail it
mail($to, null, $message, $headers);
?>

