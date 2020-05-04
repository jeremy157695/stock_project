<?php
    // check csv file is exist or not.
    if (file_exists('../csv/' . $_POST['formname'] . '.csv') == false) {
        $handle = fopen('../csv/' . $_POST['formname'] . '.csv', "w");
        fclose($handle);
    }
    
    // read csv file.
    $arraydata = array();
    $handle = fopen('../csv/' . $_POST['formname'] . '.csv', "r");
    while($data = fgetcsv($handle)) {
        $arraydata[] = $data;
    }
    fclose($handle);

    $csvarray = array($_POST['stockcode'], $_POST['stockname'], str_replace(',','', $_POST['stockprice']), str_replace(',','',$_POST['stockqty']), str_replace(',','',$_POST['stockint']), str_replace(',','',$_POST['stockfee']));
    $rowindex = intval($_POST['stockrowindex']);
    // var_dump($rowindex);
    switch($_POST['submit']) {
    case 'modify':
        $arraydata[$rowindex] = $csvarray;
        // array_splice($arraydata, $rowindex, 1, $csvarray);
        break;
    case 'delete':
        unset($arraydata[$rowindex]);
        break;
    default:
        $arraydata[] = $csvarray;    
    }
    // var_dump($arraydata);
    $handle = fopen('../csv/' . $_POST['formname'] . '.csv', "w");
    foreach($arraydata as $rowdata) {
        fputcsv($handle, $rowdata);
    }
    fclose($handle);

    $arraydata = array();
    $handle = fopen("../csv/number.csv", "r");
    while($data = fgetcsv($handle)) {
        $arraycode[] = $data[0];
        $arraydata[] = $data;
    }
    fclose($handle);

    if(in_array($_POST['stockcode'], $arraycode) == false) {
        $arraydata[] = array($_POST['stockcode'], $_POST['stockname'], '0', '0');
        $handle = fopen("../csv/number.csv", "w");
        foreach($arraydata as $rowdata) {
            fputcsv($handle, $rowdata);     
        }
        fclose($handle);
        include 'phpgetjson.php';
    }
    
    // echo '<script>document.location.href="page.php";</script>';
    header('refresh:1; url=page.php');
    exit;

?>