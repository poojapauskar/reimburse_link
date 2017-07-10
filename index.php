<html>
<body>

<h1>SmarTally</h1>

<?php


$url = 'http://127.0.0.1:4000/check_trip_status/';
$options = array(
  'http' => array(
    'header'  => array(
                  'TRIP-ID: '.$_GET['trip_id'],
                  'TOKEN: '.$_GET['token'],
                ),
    'method'  => 'GET',
  ),
);
$context = stream_context_create($options);
$output = file_get_contents($url, false,$context);
/*echo $output;*/
$arr = json_decode($output,true);
/*echo $arr['details']['Trip Status']['status'];*/

if($arr['details']['status'] == 400){
  echo "Token Mismatch";
}
else if($arr['details']['Trip Status']['status'] == "approved"){
  echo "Link Expired";
}else{
      $url = 'http://127.0.0.1:4000/mark_trip_as_reimbursed/';
      $options = array(
        'http' => array(
          'header'  => array(
                        'TRIP-ID: '.$_GET['trip_id'],
                        'STATUS: approved'
                      ),
          'method'  => 'GET',
        ),
      );
      $context = stream_context_create($options);
      $output = file_get_contents($url, false,$context);
      /*echo $output;*/
      $arr = json_decode($output,true);
      if($arr['details']['status'] == 200){
       echo "Trip Approved";
      }
      
}
?>

</body>
</html>