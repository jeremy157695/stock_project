<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set("Asia/Taipei");
$refresh = 0;
if (isset($_POST['submit'])) {
   $refresh = 1;
}

/* 
$url = 'https://mis.twse.com.tw/stock/index.jsp';
$header[] = 'Accept-Language: zh-TW';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18362');
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //important
curl_setopt($ch, CURLOPT_HEADER, $header);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 4);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);
*/

// echo '<script> alert(' . strval($refresh) . ');</script>';

if (file_exists("../csv/number.csv") == false) {
   $handle = fopen("../csv/number.csv", "w");
   fclose($handle);
}

/*     
      'https://mis.twse.com.tw/stock/api/getStock.jsp?ch=' . code . '.tw&json=1&_='
       endpoint = 'http://mis.twse.com.tw/stock/api/getStockInfo.jsp'
        # Add 1000 seconds for prevent time inaccuracy
        timestamp = int(time.time() * 1000 + 1000000)
        channels = '|'.join('tse_{}.tw'.format(target) for target in targets)
        # 將'|'插入每個list元素中間.
        self.query_url = '{}?_={}&ex_ch={}'.format(endpoint, timestamp, channels)
         
      //$endpoint = 'https://mis.twse.com.tw/stock/api/getStockInfo.jsp'; //https: important
     */
$date = date("Y-m-d");
$d = time();
$timestamp = $d * 1000 +  1000000;
// Add 1000 seconds for prevent time inaccuracy
$datalist = array();
$namelist = array();
$numberlsit = array();

$handle = fopen("../csv/number.csv", "r");
while ($data = fgetcsv($handle)) {
   for ($i = count($data); $i < 5; $i++) {
      array_push($rowdata, "0");
   }
   if ($data[3]) {
      $datalist[] = $data[3];
   } else {
      $datalist[] = '0';
   }

   if ($data[4]) {
      $namelist[] = $data[4];
   } else {
      $namelist[] = '0';
   }

   $rowdata = $data;

   if (($rowdata[2] != strval($date)) || ($rowdata[3] == '0') || ($rowdata[4] == '0')) {
      $rowdata[2] = strval($date);
      $url = 'https://mis.twse.com.tw/stock/api/getStock.jsp?ch=' . $data[0] . '.tw&json=1&_=' .  strval($timestamp++);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18362');
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //important
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $data = curl_exec($ch);
      if (curl_error($ch)) {
         $data = curl_exec($ch);
      }

      if (curl_error($ch)) {
         $datalist[(count($datalist) - 1)] = '0';
         // $namelist[] = '0';
         echo curl_error($ch);
      } else {
         $arraydata = json_decode($data, true)["msgArray"];
         $datalist[(count($datalist) - 1)] = $arraydata[0]['y'];
         $namelist[(count($namelist) - 1)] = $arraydata[0]['key'];
      }

      curl_close($ch);
   }
   $rowdata[3] =  $datalist[(count($datalist) - 1)];
   $rowdata[4] =  $namelist[(count($namelist) - 1)];
   $numberlsit[] = $rowdata;
}
fclose($handle);

/*    $handle = fopen("../csv/price.csv", "w");
   foreach($datalist as $rowdata) {
      fwrite($handle, $rowdata . PHP_EOL);     
   }
   fclose($handle);
 */
$handle = fopen("../csv/name.csv", "w");
foreach ($namelist as $rowdata) {
   fwrite($handle, $rowdata . PHP_EOL);
}
fclose($handle);

$handle = fopen("../csv/number.csv", "w");
foreach ($numberlsit as $rowdata) {
   fputcsv($handle, $rowdata);
}
fclose($handle);

// echo "Price update succeed!!";


/*  $channels = "";
      //  read csv file
      $row = 1;
      $handle = fopen("number.csv", "r");
      while($data = fgetcsv($handle))
      {
         // print_r($data);
         $datalist[] = $data;
         if($row != 1)
         {
            $channels =  $channels . '|';  
         }
         $channels = $channels . 'tse_' .  $data[0] . '.tw';
         ++$row;
      }        
      fclose($handle);
      $url = $endpoint . '?_=' . strval($timestamp) . '&ex_ch=' . $channels;
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18362');
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//important
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $data = curl_exec($ch);
      if (curl_error($ch))
      {
          echo curl_error($ch);
      }
      else
      {
         $arraydata = json_decode($data, true)["msgArray"];
         var_dump($arraydata);
         $handle = fopen("price.csv", "w");
         foreach($arraydata as $rowdata)
         {
            fwrite($handle, $rowdata["y"] . PHP_EOL);     
         }
         fclose($handle);
         echo "Price update succeed!!";
      }
      curl_close($ch); */
if ($refresh == 1) {
   header('refresh:1; url=page.php');
   exit;
}
