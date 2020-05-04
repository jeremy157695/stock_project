<?php include('phpgetjson.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>小散戶的投資</title>
    <meta charset='UTF-8' />
    <!-- 指定螢幕寬度為裝置寬度，畫面載入初始縮放比例 100% -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 匯入bootstrap -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- 匯入jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 匯入bootstrap javascript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <!-- <script src="phpgetjson.php"></script> -->

    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        tr,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: darkkhaki;
        }

        tr:hover {
            background: #FF0;
        }

        form {
            width: 100% - 5px;
            border: 2px black dashed;
            background-color: antiquewhite;
            margin: 5px;
            padding: 10px;
            offset: 5px;
        }
    </style>

</head>

<body>

    <?php
    sleep(1);

    $arraycode = array();
    $arrayname = array();
    $arrayprice = array();
    $handle = fopen("../csv/number.csv", "r");
    while ($data = fgetcsv($handle)) {
        $arraycode[] = $data[0];
        $arrayname[] = $data[1];
        $arrayprice[] = $data[3];
    }

    fclose($handle);
    $arraysummary = array();
    $handle = fopen("../csv/summary.csv", "r");
    while ($data = fgetcsv($handle)) {
        $arraysummary[] = $data;
    }
    fclose($handle);


    // var_dump($arraycode);

    /*     $arrayprice = array();
        $handle = fopen("../csv/price.csv", "r");
        while ($data = fgetcsv($handle)) {
            $arrayprice[] = $data[0];
        }
        //var_dump($arrayprice);
        fclose($handle);
    */
    echo '<datalist id="codelist">';
    $index = 0;
    foreach ($arraycode as $code) {
        echo '<option value=' . strval($code) . ' data-id=' . strval($index++) . '></option>';
    }
    echo '</datalist>';

    echo '<datalist id="namelist">';
    $index = 0;
    foreach ($arrayname as $name) {
        echo '<option value=' . strval($name)  . ' data-id=' . strval($index++) . '></option>';
    }
    echo '</datalist>';
    ?>
    <datalist id="catelist">
        <option value="存款"></option>
        <option value="提款"></option>
        <option value="買股"></option>
        <option value="賣股"></option>
        <option value="其他"></option>
    </datalist>

    <script>
        function inputSelect(id) {
            var input_select = $("#" + id).find("#stockname").eq(0).val();
            var option_length = $("#namelist").children("option").length;
            var option_id = '';
            console.log(id);
            for (var i = 0; i < option_length; i++) {
                var option_value = $("#namelist").children("option").eq(i).attr('value');
                //console.log(option_value);
                if (input_select == option_value) {
                    option_id = $("#namelist").children("option").eq(i).attr('data-id')
                    console.log(option_id);
                    $("#" + id).find("#stockcode").eq(0).attr("value", $("#codelist").children("option").eq(i).attr('value'));
                    break;
                }
            }
        }
    </script>
    <ul id="mytab" class="nav nav-tabs">
        <li><a data-toggle="tab" href="#bank1">阿布銀行</a></li>
        <li><a data-toggle="tab" href="#stock1">阿布股票</a></li>
        <li><a data-toggle="tab" href="#bank2">小鹿銀行</a></li>
        <li><a data-toggle="tab" href="#stock2">小鹿股票</a></li>
        <li><a data-toggle="tab" href="#bank3">退休銀行</a></li>
        <li><a data-toggle="tab" href="#stock3">退休股票</a></li>
        <li><a data-toggle="tab" href="#bank4">樂樂銀行</a></li>
        <li><a data-toggle="tab" href="#stock4">樂樂股票</a></li>
        <li><a data-toggle="tab" href="#bank5">Momo銀行</a></li>
        <li><a data-toggle="tab" href="#stock5">Momo股票</a></li>
        <li><a data-toggle="tab" href="#bank6">其他銀行</a></li>
        <li><a data-toggle="tab" href="#stock6">其他股票</a></li>
        <li><a data-toggle="tab" href="#home">資產</a></li>
    </ul>

    <div class="tab-content">
        <div id="bank1" class="tab-pane fade">
            <div>
                <form action="getbank.php" method="post" name="bankform1">
                    <Input type="hidden" name="formname" value="bank1" autocomplete="off">
                    <Input type="text" id="rowindex" name="rowindex" value="0" readonly="readonly" size="4" autocomplete="off">
                    日期: <Input type="date" id="bankdate" name="bankdate" size="10" autocomplete="off">
                    科目: <Input type="text" id="bankcategeory" name="bankcategeory" list="catelist" size="8" onclick="this.select()" autocomplete="off">
                    內容: <Input type="text" id="bankcontent" name="bankcontent" size="10" onclick="this.select()" autocomplete="off">
                    收支: <Input type="text" id="bankinout" name="bankinout" size="10" onclick="this.select()" autocomplete="off">
                    說明: <Input type="text" id="banknote" name="banknote" size="10" onclick="this.select()" autocomplete="off">
                    <Input type="submit" name="submit" value="add" title="增加" style="width:6em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:6em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:6em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-1">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:10em">日期</th>
                        <th style="width:10em">科目</th>
                        <th style="width:20em">內容</th>
                        <th style="width:10em">收支</th>
                        <th style="width:10em">餘額</th>
                        <th>說明</th>
                    </tr>
                    <?php
                    $handle = fopen("../csv/bank1.csv", "r");
                    $rownum = 0;
                    $subsum = 0;
                    $principal = 0;
                    while ($data = fgetcsv($handle)) {
                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";

                        if (($data[1] == '存款') or ($data[1] == '提款')) {
                            $principal += $data[3];
                        }
                        $subsum += $data[3];
                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . $data[4] . "</td>";

                        echo "</tr>";
                    }
                    fclose($handle);

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[0][2] = strval($principal);
                    $arraysummary[0][3] = strval($subsum);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle);
 */
                    ?>

                </table>
                <script>
                    var form1 = document.forms['bankform1'];
                    var table1 = document.getElementById('table-1');
                    for (var i = 0; i < table1.rows.length; i++) {
                        table1.rows[i].addEventListener('click', function() {
                            form1.elements.rowindex.value = this.cells[0].innerHTML;
                            form1.elements.bankdate.value = this.cells[1].innerHTML;
                            form1.elements.bankcategeory.value = this.cells[2].innerHTML;
                            form1.elements.bankcontent.value = this.cells[3].innerHTML;
                            form1.elements.bankinout.value = this.cells[4].innerHTML;
                            form1.elements.banknote.value = this.cells[6].innerHTML;

                            // document.getElementById('bankdate').value = this.cells[1].innerHTML;
                            // document.getElementById('bankcategeory').value = this.cells[2].innerHTML;
                            // document.getElementById('bankcontent').value = this.cells[3].innerHTML;
                            // document.getElementById('bankinout').value = this.cells[4].innerHTML;
                            // document.getElementById('banknote').value = this.cells[6].innerHTML;
                            // document.getElementById('rowindex').value = this.cells[0].innerHTML;
                        })
                    }
                </script>
            </div>
        </div>

        <div id="stock1" class="tab-pane fade">
            <div>
                <form action="getstock.php" method="post" name="stockform1" id="stockform1">
                    <Input type="hidden" name="formname" value="stock1" />
                    <Input type="text" id="stockrowindex" name="stockrowindex" value="0" readonly="readonly" size="4" />
                    代碼: <Input type="text" id="stockcode" name="stockcode" size="8" list="codelist" onclick="this.select()" autocomplete="off" />
                    名稱: <Input type="text" id="stockname" name="stockname" size="8" list="namelist" onclick="this.select()" autocomplete="off" oninput="inputSelect(this.parentNode.id)" />
                    單價: <Input type="text" id="stockprice" name="stockprice" size="8" onclick="this.select()" autocomplete="off" />
                    股數: <Input type="text" id="stockqty" name="stockqty" size="8" onclick="this.select()" autocomplete="off" />
                    股利: <Input type="text" id="stockint" name="stockint" size="8" onclick="this.select()" autocomplete="off" />
                    手續費: <Input type="text" id="stockfee" name="stockfee" size="8" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:5em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:5em" />
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:5em" />
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-2">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:5em">代碼</th>
                        <th style="width:5em">名稱</th>
                        <th style="width:5em">單價</th>
                        <th style="width:10em">股數</th>
                        <th style="width:5em">股利</th>
                        <th style="width:5em">手續費</th>
                        <th style="width:10em">成本</th>
                        <th style="width:6em">現價</th>
                        <th style="width:10em">現值</th>
                        <th style="width:10em">獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    /*                     $handle = fopen("number.csv", "r");
                        while ($data = fgetcsv($handle)) {
                            $arraycode[] = $data[0];
                        }
                        fclose($handle);
                        //var_dump($arraycode);

                        $handle = fopen("price.csv", "r");
                        while ($data = fgetcsv($handle)) {
                            $arrayprice[] = $data[0];
                        }
                        //var_dump($arrayprice);
                        fclose($handle);
    */
                    $handle = fopen("../csv/stock1.csv", "r");
                    $rownum = 0;
                    $subcost = 0;
                    $subprice = 0;
                    while ($data = fgetcsv($handle)) {
                        $rowcost = floatval($data[2]) * intval($data[3]) + intval($data[5]);

                        $pricenow = floatval($arrayprice[(array_search($data[0], $arraycode))]);
                        // var_dump($pricenow);
                        $rowprice = $pricenow  * intval($data[3]);
                        // var_dump($rowprice);
                        $diffration = 0;
                        if ($rowcost > 0) {
                            $diffration = round($rowprice / $rowcost * 100, 2);
                        } else {
                            $diffration = 0;
                        }

                        $subcost += $rowcost;
                        $subprice += $rowprice;

                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";
                        echo "<td>" . $data[4] . "</td>";
                        echo "<td>" . $data[5] . "</td>";
                        echo "<td>" . number_format(intval($rowcost)) . "</td>";
                        echo "<td>" . strval(floatval($pricenow)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice - $rowcost)) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                    }
                    fclose($handle);
                    $diffration = 0;
                    if ($subcost > 0) {
                        $diffration = round($subprice / $subcost * 100, 2);
                    }
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subprice) . '</td>';
                    echo '<td>' . number_format($subprice - $subcost) . '</td>';
                    echo '<td>' . strval($diffration) . '%</td>';
                    echo "</tr>";

                    /*                     $arraydata = array();
                        $handle = fopen("summary.csv", "r");
                        while ($data = fgetcsv($handle)) {
                            $arraydata[] = $data;
                        }
                        fclose($handle);
    */
                    $arraysummary[0][4] = strval($subprice);

                    /*                     $handle = fopen("summary.csv", "w");
                        foreach ($arraysummary as $rowdata) {
                            fputcsv($handle, $rowdata);
                        }
                        fclose($handle); */
                    ?>

                </table>
                <script>
                    var form2 = document.forms['stockform1'];
                    var table2 = document.getElementById('table-2');
                    for (var i = 0; i < table2.rows.length; i++) {
                        table2.rows[i].addEventListener('click', function() {
                            form2.elements.stockrowindex.value = this.cells[0].innerHTML;
                            form2.elements.stockcode.value = this.cells[1].innerHTML;
                            form2.elements.stockname.value = this.cells[2].innerHTML;
                            form2.elements.stockprice.value = this.cells[3].innerHTML;
                            form2.elements.stockqty.value = this.cells[4].innerHTML;
                            form2.elements.stockint.value = this.cells[5].innerHTML;
                            form2.elements.stockfee.value = this.cells[6].innerHTML;
                            /*                             document.getElementById('stockrowindex').value = this.cells[0].innerHTML;
                                                        document.getElementById('stockcode').value = this.cells[1].innerHTML;
                                                        document.getElementById('stockname').value = this.cells[2].innerHTML;
                                                        document.getElementById('stockprice').value = this.cells[3].innerHTML;
                                                        document.getElementById('stockqty').value = this.cells[4].innerHTML;
                                                        document.getElementById('stockint').value = this.cells[5].innerHTML;
                                                        document.getElementById('stockfee').value = this.cells[6].innerHTML;
                              */
                        })
                    }
                </script>
            </div>
        </div>

        <div id="bank2" class="tab-pane fade">
            <div>
                <form action="getbank.php" method="post" name="bankform2">
                    <Input type="hidden" name="formname" value="bank2">
                    <Input type="text" id="rowindex" name="rowindex" value="0" readonly="readonly" size="4">
                    日期: <Input type="date" id="bankdate" name="bankdate" size="10">
                    科目: <Input type="text" id="bankcategeory" name="bankcategeory" list="catelist" size="8" onclick="this.select()" autocomplete="off">
                    內容: <Input type="text" id="bankcontent" name="bankcontent" size="10" onclick="this.select()" autocomplete="off" />
                    收支: <Input type="text" id="bankinout" name="bankinout" size="10" onclick="this.select()" autocomplete="off" />
                    說明: <Input type="text" id="banknote" name="banknote" size="10" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:6em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:6em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:6em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-3">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:10em">日期</th>
                        <th style="width:10em">科目</th>
                        <th style="width:20em">內容</th>
                        <th style="width:10em">收支</th>
                        <th style="width:10em">餘額</th>
                        <th>說明</th>
                    </tr>
                    <?php
                    $handle = fopen("../csv/bank2.csv", "r");
                    $rownum = 0;
                    $subsum = 0;
                    $principal = 0;
                    while ($data = fgetcsv($handle)) {
                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";

                        if (($data[1] == '存款') or ($data[1] == '提款')) {
                            $principal += $data[3];
                        }
                        $subsum += $data[3];
                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . $data[4] . "</td>";

                        echo "</tr>";
                    }
                    fclose($handle);

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[1][2] = strval($principal);
                    $arraysummary[1][3] = strval($subsum);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle);
 */
                    ?>

                </table>
                <script>
                    const form3 = document.forms['bankform2'];
                    //alert(form);
                    var table3 = document.getElementById('table-3');
                    for (var i = 0; i < table3.rows.length; i++) {
                        table3.rows[i].addEventListener('click', function() {
                            form3.elements.rowindex.value = this.cells[0].innerHTML;
                            form3.elements.bankdate.value = this.cells[1].innerHTML;
                            form3.elements.bankcategeory.value = this.cells[2].innerHTML;
                            form3.elements.bankcontent.value = this.cells[3].innerHTML;
                            form3.elements.bankinout.value = this.cells[4].innerHTML;
                            form3.elements.banknote.value = this.cells[6].innerHTML;

                            // document.getElementById('bankdate').value = this.cells[1].innerHTML;
                            // document.getElementById('bankcategeory').value = this.cells[2].innerHTML;
                            // document.getElementById('bankcontent').value = this.cells[3].innerHTML;
                            // document.getElementById('bankinout').value = this.cells[4].innerHTML;
                            // document.getElementById('banknote').value = this.cells[6].innerHTML;
                            // document.getElementById('rowindex').value = this.cells[0].innerHTML;
                        })
                    }
                </script>
            </div>
            <!-- <h3>bank 2</h3> -->
            <!-- <p>Some content in bank 2.</p> -->
        </div>
        <div id="stock2" class="tab-pane fade">
            <div>
                <form action="getstock.php" method="post" name="stockform2" id="stockform2">
                    <Input type="hidden" name="formname" value="stock2" />
                    <Input type="text" id="stockrowindex" name="stockrowindex" value="0" readonly="readonly" size="4" />
                    代碼: <Input type="text" id="stockcode" name="stockcode" size="8" list="codelist" onclick="this.select()" autocomplete="off" />
                    名稱: <Input type="text" id="stockname" name="stockname" size="8" list="namelist" onclick="this.select()" autocomplete="off" oninput="inputSelect(this.parentNode.id)" />
                    單價: <Input type="text" id="stockprice" name="stockprice" size="8" onclick="this.select()" autocomplete="off" />
                    股數: <Input type="text" id="stockqty" name="stockqty" size="8" onclick="this.select()" autocomplete="off" />
                    股利: <Input type="text" id="stockint" name="stockint" size="8" onclick="this.select()" autocomplete="off" />
                    手續費: <Input type="text" id="stockfee" name="stockfee" size="8" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:5em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:5em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:5em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-4">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:5em">代碼</th>
                        <th style="width:5em">名稱</th>
                        <th style="width:5em">單價</th>
                        <th style="width:10em">股數</th>
                        <th style="width:5em">股利</th>
                        <th style="width:5em">手續費</th>
                        <th style="width:10em">成本</th>
                        <th style="width:6em">現價</th>
                        <th style="width:10em">現值</th>
                        <th style="width:10em">獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    /*                     $handle = fopen("number.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraycode[] = $data[0];
                    }
                    fclose($handle);
                    //var_dump($arraycode);

                    $handle = fopen("price.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arrayprice[] = $data[0];
                    }
                    //var_dump($arrayprice);
                    fclose($handle);
 */
                    $handle = fopen("../csv/stock2.csv", "r");
                    $rownum = 0;
                    $subcost = 0;
                    $subprice = 0;
                    while ($data = fgetcsv($handle)) {
                        $rowcost = floatval($data[2]) * intval($data[3]) + intval($data[5]);

                        $pricenow = floatval($arrayprice[(array_search($data[0], $arraycode))]);
                        // var_dump($pricenow);
                        $rowprice = $pricenow  * intval($data[3]);
                        // var_dump($rowprice);
                        $diffration = 0;
                        if ($rowcost > 0) {
                            $diffration = round($rowprice / $rowcost * 100, 2);
                        }

                        $subcost += $rowcost;
                        $subprice += $rowprice;

                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";
                        echo "<td>" . $data[4] . "</td>";
                        echo "<td>" . $data[5] . "</td>";
                        echo "<td>" . number_format(intval($rowcost)) . "</td>";
                        echo "<td>" . strval(floatval($pricenow)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice - $rowcost)) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                    }
                    fclose($handle);
                    $diffration = 0;
                    if ($subcost > 0) {
                        $diffration = round($subprice / $subcost * 100, 2);
                    }
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subprice) . '</td>';
                    echo '<td>' . number_format($subprice - $subcost) . '</td>';
                    echo '<td>' . strval($diffration) . '%</td>';
                    echo "</tr>";

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[1][4] = strval($subprice);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle); */
                    ?>

                </table>
                <script>
                    var form4 = document.forms['stockform2'];
                    var table4 = document.getElementById('table-4');
                    for (var i = 0; i < table4.rows.length; i++) {
                        table4.rows[i].addEventListener('click', function() {
                            form4.elements.stockrowindex.value = this.cells[0].innerHTML;
                            form4.elements.stockcode.value = this.cells[1].innerHTML;
                            form4.elements.stockname.value = this.cells[2].innerHTML;
                            form4.elements.stockprice.value = this.cells[3].innerHTML;
                            form4.elements.stockqty.value = this.cells[4].innerHTML;
                            form4.elements.stockint.value = this.cells[5].innerHTML;
                            form4.elements.stockfee.value = this.cells[6].innerHTML;
                            /*                             document.getElementById('stockrowindex').value = this.cells[0].innerHTML;
                                                        document.getElementById('stockcode').value = this.cells[1].innerHTML;
                                                        document.getElementById('stockname').value = this.cells[2].innerHTML;
                                                        document.getElementById('stockprice').value = this.cells[3].innerHTML;
                                                        document.getElementById('stockqty').value = this.cells[4].innerHTML;
                                                        document.getElementById('stockint').value = this.cells[5].innerHTML;
                                                        document.getElementById('stockfee').value = this.cells[6].innerHTML;
                              */
                        })
                    }
                </script>
            </div>
            <!-- <h3>stock 2</h3> -->
            <!-- <p>Some content in stock 2.</p> -->
        </div>
        <div id="bank3" class="tab-pane fade">
            <div>
                <form action="getbank.php" method="post" name="bankform3">
                    <Input type="hidden" name="formname" value="bank3">
                    <Input type="text" id="rowindex" name="rowindex" value="0" readonly="readonly" size="4">
                    日期: <Input type="date" id="bankdate" name="bankdate" size="10">
                    科目: <Input type="text" id="bankcategeory" name="bankcategeory" list="catelist" size="8" onclick="this.select()" autocomplete="off">
                    內容: <Input type="text" id="bankcontent" name="bankcontent" size="10" onclick="this.select()" autocomplete="off" />
                    收支: <Input type="text" id="bankinout" name="bankinout" size="10" onclick="this.select()" autocomplete="off" />
                    說明: <Input type="text" id="banknote" name="banknote" size="10" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:6em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:6em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:6em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-5">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:10em">日期</th>
                        <th style="width:10em">科目</th>
                        <th style="width:20em">內容</th>
                        <th style="width:10em">收支</th>
                        <th style="width:10em">餘額</th>
                        <th>說明</th>
                    </tr>
                    <?php
                    $handle = fopen("../csv/bank3.csv", "r");
                    $rownum = 0;
                    $subsum = 0;
                    $principal = 0;
                    while ($data = fgetcsv($handle)) {
                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";

                        if (($data[1] == '存款') or ($data[1] == '提款')) {
                            $principal += $data[3];
                        }
                        $subsum += $data[3];
                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . $data[4] . "</td>";

                        echo "</tr>";
                    }
                    fclose($handle);

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[2][2] = strval($principal);
                    $arraysummary[2][3] = strval($subsum);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle);
 */
                    ?>

                </table>
                <script>
                    var form5 = document.forms['bankform3'];
                    var table5 = document.getElementById('table-5');
                    for (var i = 0; i < table5.rows.length; i++) {
                        table5.rows[i].addEventListener('click', function() {
                            form5.elements.rowindex.value = this.cells[0].innerHTML;
                            form5.elements.bankdate.value = this.cells[1].innerHTML;
                            form5.elements.bankcategeory.value = this.cells[2].innerHTML;
                            form5.elements.bankcontent.value = this.cells[3].innerHTML;
                            form5.elements.bankinout.value = this.cells[4].innerHTML;
                            form5.elements.banknote.value = this.cells[6].innerHTML;

                            // document.getElementById('bankdate').value = this.cells[1].innerHTML;
                            // document.getElementById('bankcategeory').value = this.cells[2].innerHTML;
                            // document.getElementById('bankcontent').value = this.cells[3].innerHTML;
                            // document.getElementById('bankinout').value = this.cells[4].innerHTML;
                            // document.getElementById('banknote').value = this.cells[6].innerHTML;
                            // document.getElementById('rowindex').value = this.cells[0].innerHTML;
                        })
                    }
                </script>
            </div>


            <!-- <h3>bank 3</h3> -->
            <!-- <p>Some content in bank 3.</p> -->
        </div>
        <div id="stock3" class="tab-pane fade">
            <div>
                <form action="getstock.php" method="post" name="stockform3" id="stockform3">
                    <Input type="hidden" name="formname" value="stock3">
                    <Input type="text" id="stockrowindex" name="stockrowindex" value="0" readonly="readonly" size="4">
                    代碼: <Input type="text" id="stockcode" name="stockcode" size="8" list="codelist" onclick="this.select()" autocomplete="off" />
                    名稱: <Input type="text" id="stockname" name="stockname" size="8" list="namelist" onclick="this.select()" autocomplete="off" oninput="inputSelect(this.parentNode.id)" />
                    單價: <Input type="text" id="stockprice" name="stockprice" size="8" onclick="this.select()" autocomplete="off" />
                    股數: <Input type="text" id="stockqty" name="stockqty" size="8" onclick="this.select()" autocomplete="off" />
                    股利: <Input type="text" id="stockint" name="stockint" size="8" onclick="this.select()" autocomplete="off" />
                    手續費: <Input type="text" id="stockfee" name="stockfee" size="8" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:5em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:5em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:5em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-6">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:5em">代碼</th>
                        <th style="width:5em">名稱</th>
                        <th style="width:5em">單價</th>
                        <th style="width:10em">股數</th>
                        <th style="width:5em">股利</th>
                        <th style="width:5em">手續費</th>
                        <th style="width:10em">成本</th>
                        <th style="width:6em">現價</th>
                        <th style="width:10em">現值</th>
                        <th style="width:10em">獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    /*                     $handle = fopen("number.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraycode[] = $data[0];
                    }
                    fclose($handle);
                    //var_dump($arraycode);

                    $handle = fopen("price.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arrayprice[] = $data[0];
                    }
                    //var_dump($arrayprice);
                    fclose($handle);
 */
                    $handle = fopen("../csv/stock3.csv", "r");
                    $rownum = 0;
                    $subcost = 0;
                    $subprice = 0;
                    while ($data = fgetcsv($handle)) {
                        $rowcost = floatval($data[2]) * intval($data[3]) + intval($data[5]);

                        $pricenow = floatval($arrayprice[(array_search($data[0], $arraycode))]);
                        // var_dump($pricenow);
                        $rowprice = $pricenow  * intval($data[3]);
                        // var_dump($rowprice);
                        $diffration = 0;
                        if ($rowcost > 0) {
                            $diffration = round($rowprice / $rowcost * 100, 2);
                        }

                        $subcost += $rowcost;
                        $subprice += $rowprice;

                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";
                        echo "<td>" . $data[4] . "</td>";
                        echo "<td>" . $data[5] . "</td>";
                        echo "<td>" . number_format(intval($rowcost)) . "</td>";
                        echo "<td>" . strval(floatval($pricenow)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice - $rowcost)) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                    }
                    fclose($handle);
                    $diffration = 0;
                    if ($subcost > 0) {
                        $diffration = round($subprice / $subcost * 100, 2);
                    }
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subprice) . '</td>';
                    echo '<td>' . number_format($subprice - $subcost) . '</td>';
                    echo '<td>' . strval($diffration) . '%</td>';
                    echo "</tr>";

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[2][4] = strval($subprice);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle); */
                    ?>

                </table>
                <script>
                    var form6 = document.forms['stockform3'];
                    var table6 = document.getElementById('table-6');
                    for (var i = 0; i < table6.rows.length; i++) {
                        table6.rows[i].addEventListener('click', function() {
                            form6.elements.stockrowindex.value = this.cells[0].innerHTML;
                            form6.elements.stockcode.value = this.cells[1].innerHTML;
                            form6.elements.stockname.value = this.cells[2].innerHTML;
                            form6.elements.stockprice.value = this.cells[3].innerHTML;
                            form6.elements.stockqty.value = this.cells[4].innerHTML;
                            form6.elements.stockint.value = this.cells[5].innerHTML;
                            form6.elements.stockfee.value = this.cells[6].innerHTML;
                            /*                             document.getElementById('stockrowindex').value = this.cells[0].innerHTML;
                                                        document.getElementById('stockcode').value = this.cells[1].innerHTML;
                                                        document.getElementById('stockname').value = this.cells[2].innerHTML;
                                                        document.getElementById('stockprice').value = this.cells[3].innerHTML;
                                                        document.getElementById('stockqty').value = this.cells[4].innerHTML;
                                                        document.getElementById('stockint').value = this.cells[5].innerHTML;
                                                        document.getElementById('stockfee').value = this.cells[6].innerHTML;
                              */
                        })
                    }
                </script>
            </div>
            <!-- <h3>stock 3</h3> -->
            <!-- <p>Some content in stock 3.</p> -->
        </div>
        <div id="bank4" class="tab-pane fade">
            <div>
                <form action="getbank.php" method="post" name="bankform4">
                    <Input type="hidden" name="formname" value="bank4">
                    <Input type="text" id="rowindex" name="rowindex" value="0" readonly="readonly" size="4">
                    日期: <Input type="date" id="bankdate" name="bankdate" size="10">
                    科目: <Input type="text" id="bankcategeory" name="bankcategeory" list="catelist" size="8" onclick="this.select()" autocomplete="off">
                    內容: <Input type="text" id="bankcontent" name="bankcontent" size="10" onclick="this.select()" autocomplete="off" />
                    收支: <Input type="text" id="bankinout" name="bankinout" size="10" onclick="this.select()" autocomplete="off" />
                    說明: <Input type="text" id="banknote" name="banknote" size="10" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:6em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:6em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:6em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-7">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:10em">日期</th>
                        <th style="width:10em">科目</th>
                        <th style="width:20em">內容</th>
                        <th style="width:10em">收支</th>
                        <th style="width:10em">餘額</th>
                        <th>說明</th>
                    </tr>
                    <?php
                    $handle = fopen("../csv/bank4.csv", "r");
                    $rownum = 0;
                    $subsum = 0;
                    $principal = 0;
                    while ($data = fgetcsv($handle)) {
                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";

                        if (($data[1] == '存款') or ($data[1] == '提款')) {
                            $principal += $data[3];
                        }
                        $subsum += $data[3];
                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . $data[4] . "</td>";

                        echo "</tr>";
                    }
                    fclose($handle);

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[3][2] = strval($principal);
                    $arraysummary[3][3] = strval($subsum);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle);
 */
                    ?>

                </table>
                <script>
                    var form7 = document.forms['bankform4'];
                    var table7 = document.getElementById('table-7');
                    for (var i = 0; i < table7.rows.length; i++) {
                        table7.rows[i].addEventListener('click', function() {
                            form7.elements.rowindex.value = this.cells[0].innerHTML;
                            form7.elements.bankdate.value = this.cells[1].innerHTML;
                            form7.elements.bankcategeory.value = this.cells[2].innerHTML;
                            form7.elements.bankcontent.value = this.cells[3].innerHTML;
                            form7.elements.bankinout.value = this.cells[4].innerHTML;
                            form7.elements.banknote.value = this.cells[6].innerHTML;

                            // document.getElementById('bankdate').value = this.cells[1].innerHTML;
                            // document.getElementById('bankcategeory').value = this.cells[2].innerHTML;
                            // document.getElementById('bankcontent').value = this.cells[3].innerHTML;
                            // document.getElementById('bankinout').value = this.cells[4].innerHTML;
                            // document.getElementById('banknote').value = this.cells[6].innerHTML;
                            // document.getElementById('rowindex').value = this.cells[0].innerHTML;
                        })
                    }
                </script>
            </div>

            <!-- <h3>bank 4</h3> -->
            <!-- <p>Some content in bank 4.</p> -->
        </div>
        <div id="stock4" class="tab-pane fade">
            <div>
                <form action="getstock.php" method="post" name="stockform4" id="stockform4">
                    <Input type="hidden" name="formname" value="stock4">
                    <Input type="text" id="stockrowindex" name="stockrowindex" value="0" readonly="readonly" size="4">
                    代碼: <Input type="text" id="stockcode" name="stockcode" size="8" list="codelist" onclick="this.select()" autocomplete="off" />
                    名稱: <Input type="text" id="stockname" name="stockname" size="8" list="namelist" onclick="this.select()" autocomplete="off" oninput="inputSelect(this.parentNode.id)" />
                    單價: <Input type="text" id="stockprice" name="stockprice" size="8" onclick="this.select()" autocomplete="off" />
                    股數: <Input type="text" id="stockqty" name="stockqty" size="8" onclick="this.select()" autocomplete="off" />
                    股利: <Input type="text" id="stockint" name="stockint" size="8" onclick="this.select()" autocomplete="off" />
                    手續費: <Input type="text" id="stockfee" name="stockfee" size="8" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:5em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:5em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:5em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-8">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:5em">代碼</th>
                        <th style="width:5em">名稱</th>
                        <th style="width:5em">單價</th>
                        <th style="width:10em">股數</th>
                        <th style="width:5em">股利</th>
                        <th style="width:5em">手續費</th>
                        <th style="width:10em">成本</th>
                        <th style="width:6em">現價</th>
                        <th style="width:10em">現值</th>
                        <th style="width:10em">獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    /*                     $handle = fopen("number.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraycode[] = $data[0];
                    }
                    fclose($handle);
                    //var_dump($arraycode);

                    $handle = fopen("price.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arrayprice[] = $data[0];
                    }
                    //var_dump($arrayprice);
                    fclose($handle);
 */
                    $handle = fopen("../csv/stock4.csv", "r");
                    $rownum = 0;
                    $subcost = 0;
                    $subprice = 0;
                    while ($data = fgetcsv($handle)) {
                        $rowcost = floatval($data[2]) * intval($data[3]) + intval($data[5]);

                        $pricenow = floatval($arrayprice[(array_search($data[0], $arraycode))]);
                        // var_dump($pricenow);
                        $rowprice = $pricenow  * intval($data[3]);
                        // var_dump($rowprice);
                        $diffration = 0;
                        if ($rowcost > 0) {
                            $diffration = round($rowprice / $rowcost * 100, 2);
                        }

                        $subcost += $rowcost;
                        $subprice += $rowprice;

                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";
                        echo "<td>" . $data[4] . "</td>";
                        echo "<td>" . $data[5] . "</td>";
                        echo "<td>" . number_format(intval($rowcost)) . "</td>";
                        echo "<td>" . strval(floatval($pricenow)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice - $rowcost)) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                    }
                    fclose($handle);
                    $diffration = 0;
                    if ($subcost > 0) {
                        $diffration = round($subprice / $subcost * 100, 2);
                    }
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subprice) . '</td>';
                    echo '<td>' . number_format($subprice - $subcost) . '</td>';
                    echo '<td>' . strval($diffration) . '%</td>';
                    echo "</tr>";

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[3][4] = strval($subprice);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle); */
                    ?>

                </table>
                <script>
                    var form8 = document.forms['stockform4'];
                    var table8 = document.getElementById('table-8');
                    for (var i = 0; i < table8.rows.length; i++) {
                        table8.rows[i].addEventListener('click', function() {
                            form8.elements.stockrowindex.value = this.cells[0].innerHTML;
                            form8.elements.stockcode.value = this.cells[1].innerHTML;
                            form8.elements.stockname.value = this.cells[2].innerHTML;
                            form8.elements.stockprice.value = this.cells[3].innerHTML;
                            form8.elements.stockqty.value = this.cells[4].innerHTML;
                            form8.elements.stockint.value = this.cells[5].innerHTML;
                            form8.elements.stockfee.value = this.cells[6].innerHTML;
                            /*                             document.getElementById('stockrowindex').value = this.cells[0].innerHTML;
                                                        document.getElementById('stockcode').value = this.cells[1].innerHTML;
                                                        document.getElementById('stockname').value = this.cells[2].innerHTML;
                                                        document.getElementById('stockprice').value = this.cells[3].innerHTML;
                                                        document.getElementById('stockqty').value = this.cells[4].innerHTML;
                                                        document.getElementById('stockint').value = this.cells[5].innerHTML;
                                                        document.getElementById('stockfee').value = this.cells[6].innerHTML;
                              */
                        })
                    }
                </script>
            </div>
            <!-- <h3>stock 4</h3> -->
            <!-- <p>Some content in stock 4.</p> -->
        </div>
        <div id="bank5" class="tab-pane fade">
            <div>
                <form action="getbank.php" method="post" name="bankform5">
                    <Input type="hidden" name="formname" value="bank5">
                    <Input type="text" id="rowindex" name="rowindex" value="0" readonly="readonly" size="4">
                    日期: <Input type="date" id="bankdate" name="bankdate" size="10">
                    科目: <Input type="text" id="bankcategeory" name="bankcategeory" list="catelist" size="8" onclick="this.select()" autocomplete="off">
                    內容: <Input type="text" id="bankcontent" name="bankcontent" size="10" onclick="this.select()" autocomplete="off" />
                    收支: <Input type="text" id="bankinout" name="bankinout" size="10" onclick="this.select()" autocomplete="off" />
                    說明: <Input type="text" id="banknote" name="banknote" size="10" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:6em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:6em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:6em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-9">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:10em">日期</th>
                        <th style="width:10em">科目</th>
                        <th style="width:20em">內容</th>
                        <th style="width:10em">收支</th>
                        <th style="width:10em">餘額</th>
                        <th>說明</th>
                    </tr>
                    <?php
                    $handle = fopen("../csv/bank5.csv", "r");
                    $rownum = 0;
                    $subsum = 0;
                    $principal = 0;
                    while ($data = fgetcsv($handle)) {
                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";

                        if (($data[1] == '存款') or ($data[1] == '提款')) {
                            $principal += $data[3];
                        }
                        $subsum += $data[3];
                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . $data[4] . "</td>";

                        echo "</tr>";
                    }
                    fclose($handle);

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[4][2] = strval($principal);
                    $arraysummary[4][3] = strval($subsum);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle);
 */
                    ?>

                </table>
                <script>
                    var form9 = document.forms['bankform5'];
                    var table9 = document.getElementById('table-9');
                    for (var i = 0; i < table9.rows.length; i++) {
                        table9.rows[i].addEventListener('click', function() {
                            form9.elements.rowindex.value = this.cells[0].innerHTML;
                            form9.elements.bankdate.value = this.cells[1].innerHTML;
                            form9.elements.bankcategeory.value = this.cells[2].innerHTML;
                            form9.elements.bankcontent.value = this.cells[3].innerHTML;
                            form9.elements.bankinout.value = this.cells[4].innerHTML;
                            form9.elements.banknote.value = this.cells[6].innerHTML;

                            // document.getElementById('bankdate').value = this.cells[1].innerHTML;
                            // document.getElementById('bankcategeory').value = this.cells[2].innerHTML;
                            // document.getElementById('bankcontent').value = this.cells[3].innerHTML;
                            // document.getElementById('bankinout').value = this.cells[4].innerHTML;
                            // document.getElementById('banknote').value = this.cells[6].innerHTML;
                            // document.getElementById('rowindex').value = this.cells[0].innerHTML;
                        })
                    }
                </script>
            </div>

            <!-- <h3>bank 5</h3> -->
            <!-- <p>Some content in bank 5.</p> -->
        </div>
        <div id="stock5" class="tab-pane fade">
            <div>
                <form action="getstock.php" method="post" name="stockform5" id="stockform5">
                    <Input type="hidden" name="formname" value="stock5">
                    <Input type="text" id="stockrowindex" name="stockrowindex" value="0" readonly="readonly" size="4">
                    代碼: <Input type="text" id="stockcode" name="stockcode" size="8" list="codelist" onclick="this.select()" autocomplete="off" />
                    名稱: <Input type="text" id="stockname" name="stockname" size="8" list="namelist" onclick="this.select()" autocomplete="off" oninput="inputSelect(this.parentNode.id)" />
                    單價: <Input type="text" id="stockprice" name="stockprice" size="8" onclick="this.select()" autocomplete="off" />
                    股數: <Input type="text" id="stockqty" name="stockqty" size="8" onclick="this.select()" autocomplete="off" />
                    股利: <Input type="text" id="stockint" name="stockint" size="8" onclick="this.select()" autocomplete="off" />
                    手續費: <Input type="text" id="stockfee" name="stockfee" size="8" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:5em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:5em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:5em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-10">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:5em">代碼</th>
                        <th style="width:5em">名稱</th>
                        <th style="width:5em">單價</th>
                        <th style="width:10em">股數</th>
                        <th style="width:5em">股利</th>
                        <th style="width:5em">手續費</th>
                        <th style="width:10em">成本</th>
                        <th style="width:6em">現價</th>
                        <th style="width:10em">現值</th>
                        <th style="width:10em">獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    /*                     $handle = fopen("number.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraycode[] = $data[0];
                    }
                    fclose($handle);
                    //var_dump($arraycode);

                    $handle = fopen("price.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arrayprice[] = $data[0];
                    }
                    //var_dump($arrayprice);
                    fclose($handle);
 */
                    $handle = fopen("../csv/stock5.csv", "r");
                    $rownum = 0;
                    $subcost = 0;
                    $subprice = 0;
                    while ($data = fgetcsv($handle)) {
                        $rowcost = floatval($data[2]) * intval($data[3]) + intval($data[5]);

                        $pricenow = floatval($arrayprice[(array_search($data[0], $arraycode))]);
                        // var_dump($pricenow);
                        $rowprice = $pricenow  * intval($data[3]);
                        // var_dump($rowprice);
                        $diffration = 0;
                        if ($rowcost > 0) {
                            $diffration = round($rowprice / $rowcost * 100, 2);
                        }

                        $subcost += $rowcost;
                        $subprice += $rowprice;

                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";
                        echo "<td>" . $data[4] . "</td>";
                        echo "<td>" . $data[5] . "</td>";
                        echo "<td>" . number_format(intval($rowcost)) . "</td>";
                        echo "<td>" . strval(floatval($pricenow)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice - $rowcost)) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                    }
                    fclose($handle);
                    $diffration = 0;
                    if ($subcost > 0) {
                        $diffration = round($subprice / $subcost * 100, 2);
                    }
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subprice) . '</td>';
                    echo '<td>' . number_format($subprice - $subcost) . '</td>';
                    echo '<td>' . strval($diffration) . '%</td>';
                    echo "</tr>";

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[4][4] = strval($subprice);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle); */
                    ?>

                </table>
                <script>
                    var form10 = document.forms['stockform5'];
                    var table10 = document.getElementById('table-10');
                    for (var i = 0; i < table10.rows.length; i++) {
                        table10.rows[i].addEventListener('click', function() {
                            form10.elements.stockrowindex.value = this.cells[0].innerHTML;
                            form10.elements.stockcode.value = this.cells[1].innerHTML;
                            form10.elements.stockname.value = this.cells[2].innerHTML;
                            form10.elements.stockprice.value = this.cells[3].innerHTML;
                            form10.elements.stockqty.value = this.cells[4].innerHTML;
                            form10.elements.stockint.value = this.cells[5].innerHTML;
                            form10.elements.stockfee.value = this.cells[6].innerHTML;
                            /*                             document.getElementById('stockrowindex').value = this.cells[0].innerHTML;
                                                        document.getElementById('stockcode').value = this.cells[1].innerHTML;
                                                        document.getElementById('stockname').value = this.cells[2].innerHTML;
                                                        document.getElementById('stockprice').value = this.cells[3].innerHTML;
                                                        document.getElementById('stockqty').value = this.cells[4].innerHTML;
                                                        document.getElementById('stockint').value = this.cells[5].innerHTML;
                                                        document.getElementById('stockfee').value = this.cells[6].innerHTML;
                              */
                        })
                    }
                </script>
            </div>

            <!-- <h3>stock 5</h3> -->
            <!-- <p>Some content in stock 5.</p> -->
        </div>
        <div id="bank6" class="tab-pane fade">
            <div>
                <form action="getbank.php" method="post" name="bankform6">
                    <Input type="hidden" name="formname" value="bank6">
                    <Input type="text" id="rowindex" name="rowindex" value="0" readonly="readonly" size="4">
                    日期: <Input type="date" id="bankdate" name="bankdate" size="10">
                    科目: <Input type="text" id="bankcategeory" name="bankcategeory" list="catelist" size="8" onclick="this.select()" autocomplete="off"> 
                    內容: <Input type="text" id="bankcontent" name="bankcontent" size="10" onclick="this.select()" autocomplete="off" />
                    收支: <Input type="text" id="bankinout" name="bankinout" size="10" onclick="this.select()" autocomplete="off" />
                    說明: <Input type="text" id="banknote" name="banknote" size="10" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:6em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:6em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:6em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-11">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:10em">日期</th>
                        <th style="width:10em">科目</th>
                        <th style="width:20em">內容</th>
                        <th style="width:10em">收支</th>
                        <th style="width:10em">餘額</th>
                        <th>說明</th>
                    </tr>
                    <?php
                    $handle = fopen("../csv/bank6.csv", "r");
                    $rownum = 0;
                    $subsum = 0;
                    $principal = 0;
                    while ($data = fgetcsv($handle)) {
                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";

                        if (($data[1] == '存款') or ($data[1] == '提款')) {
                            $principal += $data[3];
                        }
                        $subsum += $data[3];
                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . $data[4] . "</td>";

                        echo "</tr>";
                    }
                    fclose($handle);

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[5][2] = strval($principal);
                    $arraysummary[5][3] = strval($subsum);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle);
 */
                    ?>

                </table>
                <script>
                    var form11 = document.forms['bankform6'];
                    var table11 = document.getElementById('table-11');
                    for (var i = 0; i < table11.rows.length; i++) {
                        table11.rows[i].addEventListener('click', function() {
                            form11.elements.rowindex.value = this.cells[0].innerHTML;
                            form11.elements.bankdate.value = this.cells[1].innerHTML;
                            form11.elements.bankcategeory.value = this.cells[2].innerHTML;
                            form11.elements.bankcontent.value = this.cells[3].innerHTML;
                            form11.elements.bankinout.value = this.cells[4].innerHTML;
                            form11.elements.banknote.value = this.cells[6].innerHTML;

                            // document.getElementById('bankdate').value = this.cells[1].innerHTML;
                            // document.getElementById('bankcategeory').value = this.cells[2].innerHTML;
                            // document.getElementById('bankcontent').value = this.cells[3].innerHTML;
                            // document.getElementById('bankinout').value = this.cells[4].innerHTML;
                            // document.getElementById('banknote').value = this.cells[6].innerHTML;
                            // document.getElementById('rowindex').value = this.cells[0].innerHTML;
                        })
                    }
                </script>
            </div>

            <!-- <h3>bank 6</h3> -->
            <!-- <p>Some content in bank 6.</p> -->
        </div>
        <div id="stock6" class="tab-pane fade">
            <div>
                <form action="getstock.php" method="post" name="stockform6" id="stockform6">
                    <Input type="hidden" name="formname" value="stock6" />
                    <Input type="text" id="stockrowindex" name="stockrowindex" value="0" readonly="readonly" size="4" />
                    代碼: <Input type="text" id="stockcode" name="stockcode" size="8" list="codelist" onclick="this.select()" autocomplete="off" />
                    名稱: <Input type="text" id="stockname" name="stockname" size="8" list="namelist" autocomplete="off" onclick="this.select()" oninput="inputSelect(this.parentNode.id)" />
                    單價: <Input type="text" id="stockprice" name="stockprice" size="8" onclick="this.select()" autocomplete="off" />
                    股數: <Input type="text" id="stockqty" name="stockqty" size="8" onclick="this.select()" autocomplete="off" />
                    股利: <Input type="text" id="stockint" name="stockint" size="8" onclick="this.select()" autocomplete="off" />
                    手續費: <Input type="text" id="stockfee" name="stockfee" size="8" onclick="this.select()" autocomplete="off" />
                    <Input type="submit" name="submit" value="add" title="增加" style="width:5em">
                    <Input type="submit" name="submit" value="modify" title="修改" style="width:5em">
                    <Input type="submit" name="submit" value="delete" title="刪除" style="width:5em">
                </form>
            </div>
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <table id="table-12">
                    <tr>
                        <th style="width:3em">編號</th>
                        <th style="width:5em">代碼</th>
                        <th style="width:5em">名稱</th>
                        <th style="width:5em">單價</th>
                        <th style="width:10em">股數</th>
                        <th style="width:5em">股利</th>
                        <th style="width:5em">手續費</th>
                        <th style="width:10em">成本</th>
                        <th style="width:6em">現價</th>
                        <th style="width:10em">現值</th>
                        <th style="width:10em">獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    /*                     $handle = fopen("number.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraycode[] = $data[0];
                    }
                    fclose($handle);
                    //var_dump($arraycode);

                    $handle = fopen("price.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arrayprice[] = $data[0];
                    }
                    //var_dump($arrayprice);
                    fclose($handle);
 */
                    $handle = fopen("../csv/stock6.csv", "r");
                    $rownum = 0;
                    $subcost = 0;
                    $subprice = 0;
                    while ($data = fgetcsv($handle)) {
                        $rowcost = floatval($data[2]) * intval($data[3])  + intval($data[5]);

                        $pricenow = floatval($arrayprice[(array_search($data[0], $arraycode))]);
                        // var_dump($pricenow);
                        $rowprice = $pricenow  * intval($data[3]);
                        // var_dump($rowprice);
                        $diffration = 0;
                        if ($rowcost > 0) {
                            $diffration = round($rowprice / $rowcost * 100, 2);
                        }

                        $subcost += $rowcost;
                        $subprice += $rowprice;

                        echo "<tr>";
                        echo "<td>" . strval($rownum++) . "</td>";
                        echo "<td>" . $data[0] . "</td>";
                        echo "<td>" . $data[1] . "</td>";
                        echo "<td>" . $data[2] . "</td>";
                        echo "<td>" . number_format(intval($data[3])) . "</td>";
                        echo "<td>" . $data[4] . "</td>";
                        echo "<td>" . $data[5] . "</td>";
                        echo "<td>" . number_format(intval($rowcost)) . "</td>";
                        echo "<td>" . strval(floatval($pricenow)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice)) . "</td>";
                        echo "<td>" . number_format(intval($rowprice - $rowcost)) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                    }
                    fclose($handle);
                    $diffration = 0;
                    if ($subcost > 0) {
                        $diffration = round($subprice / $subcost * 100, 2);
                    }
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subprice) . '</td>';
                    echo '<td>' . number_format($subprice - $subcost) . '</td>';
                    echo '<td>' . strval($diffration) . '%</td>';
                    echo "</tr>";

                    /*                     $arraydata = array();
                    $handle = fopen("summary.csv", "r");
                    while ($data = fgetcsv($handle)) {
                        $arraydata[] = $data;
                    }
                    fclose($handle);
 */
                    $arraysummary[5][4] = strval($subprice);

                    /*                     $handle = fopen("summary.csv", "w");
                    foreach ($arraysummary as $rowdata) {
                        fputcsv($handle, $rowdata);
                    }
                    fclose($handle); */
                    ?>

                </table>
                <script>
                    var form12 = document.forms['stockform6'];
                    var table12 = document.getElementById('table-12');
                    for (var i = 0; i < table12.rows.length; i++) {
                        table12.rows[i].addEventListener('click', function() {
                            form12.elements.stockrowindex.value = this.cells[0].innerHTML;
                            form12.elements.stockcode.value = this.cells[1].innerHTML;
                            form12.elements.stockname.value = this.cells[2].innerHTML;
                            form12.elements.stockprice.value = this.cells[3].innerHTML;
                            form12.elements.stockqty.value = this.cells[4].innerHTML;
                            form12.elements.stockint.value = this.cells[5].innerHTML;
                            form12.elements.stockfee.value = this.cells[6].innerHTML;
                            /*                             document.getElementById('stockrowindex').value = this.cells[0].innerHTML;
                                                        document.getElementById('stockcode').value = this.cells[1].innerHTML;
                                                        document.getElementById('stockname').value = this.cells[2].innerHTML;
                                                        document.getElementById('stockprice').value = this.cells[3].innerHTML;
                                                        document.getElementById('stockqty').value = this.cells[4].innerHTML;
                                                        document.getElementById('stockint').value = this.cells[5].innerHTML;
                                                        document.getElementById('stockfee').value = this.cells[6].innerHTML;
                              */
                        })
                    }
                </script>
            </div>

            <!-- <h3>stock 6</h3> -->
            <!-- <p>Some content in stock 6.</p> -->
        </div>

        <div id="home" class="tab-pane fade">
            <div style="border: 2px dashed; margin: 5px; padding: 10px;">
                <div>
                    <form action="phpgetjson.php" method="post" name="totalform">
                        <Input type="submit" name="submit" value="refresh" title="更新" style="width:6em">
                    </form>
                </div>
                <table>
                    <tr>
                        <th>編號</th>
                        <th>名稱</th>
                        <th>本金</th>
                        <th>餘額</th>
                        <th>股票現值</th>
                        <th>小計</th>
                        <th>獲利</th>
                        <th>維持率</th>
                    </tr>
                    <?php
                    // $handle = fopen("summary.csv", "r");
                    $subcost = 0;
                    $subover = 0;
                    $substock = 0;
                    $subtotal = 0;
                    $subprofit = 0;
                    foreach ($arraysummary as $rowdata) {
                        echo "<tr>";
                        echo "<td>" . $rowdata[0] . "</td>";
                        echo "<td>" . $rowdata[1] . "</td>";
                        echo "<td>" . number_format(intval($rowdata[2])) . "</td>";
                        echo "<td>" . number_format(intval($rowdata[3])) . "</td>";
                        echo "<td>" . number_format(intval($rowdata[4])) . "</td>";

                        $subcost = $subcost + intval($rowdata[2]);
                        $subover = $subover + intval($rowdata[3]);
                        $substock = $substock + intval($rowdata[4]);

                        $subsum = intval($rowdata[3]) + intval($rowdata[4]);

                        $subtotal = $subtotal + $subsum;

                        $diffamount = $subsum - intval($rowdata[2]);

                        $subprofit = $subprofit + $diffamount;

                        if (intval($rowdata[2]) > 0) {
                            $diffration = round($subsum / intval($rowdata[2]) * 100, 2);
                        } else {
                            $diffration = 0;
                        }

                        echo "<td>" . number_format($subsum) . "</td>";
                        echo "<td>" . number_format($diffamount) . "</td>";
                        echo "<td>" . strval($diffration) . "%</td>";
                        echo "</tr>";
                    }
                    /*                     while ($data = fgetcsv($handle)) {
                            echo "<tr>";
                            echo "<td>" . $data[0] . "</td>";
                            echo "<td>" . $data[1] . "</td>";
                            echo "<td>" . number_format(intval($data[2])) . "</td>";
                            echo "<td>" . number_format(intval($data[3])) . "</td>";
                            echo "<td>" . number_format(intval($data[4])) . "</td>";

                            $subcost = $subcost + intval($data[2]);
                            $subover = $subover + intval($data[3]);
                            $substock = $substock;

                            $subsum = intval($data[3]);

                            $subtotal = $subtotal + $subsum;

                            $diffamount = $subsum - intval($data[2]);

                            $subprofit = $subprofit + $diffamount;

                            if (intval($data[2]) != 0) {
                                $diffration = round($subsum / intval($data[2]) * 100, 2);
                            } else {
                                $diffration = 0;
                            }

                            echo "<td>" . number_format($subsum) . "</td>";
                            echo "<td>" . number_format($diffamount) . "</td>";
                            echo "<td>" . strval($diffration) . "%</td>";
                            echo "</tr>";
                        }
                        fclose($handle);
    */
                    $totaldiff = round($subtotal / $subcost * 100, 2);
                    echo "<tr>";
                    echo '<td style="border: 0px;">總計</td>';
                    echo '<td style="border: 0px;"></td>';
                    echo '<td>' . number_format($subcost) . '</td>';
                    echo '<td>' . number_format($subover) . '</td>';
                    echo '<td>' . number_format($substock) . '</td>';
                    echo '<td>' . number_format($subtotal) . '</td>';
                    echo '<td>' . number_format($subprofit) . '</td>';
                    echo '<td>' . strval($totaldiff) . '%</td>';
                    echo "</tr>";
                    ?>
                </table>

            </div>
        </div>
    </div>

    <?php
    $handle = fopen("../csv/summary.csv", "w");
    foreach ($arraysummary as $rowdata) {
        fputcsv($handle, $rowdata);
    }
    fclose($handle);
    ?>
    <!-- 自動點選第一頁 -->
    <script>
        $(function() {
            // $('#mytab a:last').tab('show');
            $('#mytab li:eq(1) a').tab('show')
        })
    </script>
</body>

</html>