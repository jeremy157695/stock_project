<?php
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

    $csvarray = array($_POST['bankdate'], $_POST['bankcategeory'], $_POST['bankcontent'], str_replace(',','',$_POST['bankinout']), $_POST['banknote']);
    $rowindex = intval($_POST['rowindex']);
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
    
    // echo '<script>document.location.href="page.php";</script>';
    header('refresh:1; url=page.php');
    exit;

?>