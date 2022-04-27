<?php
require_once("connection.php");
//include "ws.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Web SQL</title>
    <style>
        body{

        }
        table,tr,th,td{
            border-collapse:collapse;
            border: 1px solid black;

        }
        th{
            background-color: cadetblue;
            justify-content: center;
        }
        td,tr{
            background-color: lightgrey;
        }
    </style>
    <script>
        <?php
        //fetch category
        $query = "SELECT * FROM category";
        $rs=$dbx->query($query);
        $category[] = "";
        while($dt=$rs->fetch()){
            $category[] = $dt;
        }
        //fetch item
        $query = "SELECT * FROM item";
        $rs=$dbx->query($query);
        $item[] = "";
        while($dt=$rs->fetch()){
            $item[] = $dt;
        }
        //print_r($category);

        //fetch supplier
        $query = "SELECT * FROM supplier";
        $rs=$dbx->query($query);
        $supplier[] = "";
        while($dt=$rs->fetch()){
            $supplier[] = $dt;
        }
        ?>

        var catDate="";
        var itemDate="";
        var supplierDate="";


        // This function here is used to write out any errors I get to the console.
        function errorHandler(transaction, error) {
            console.log('Oops. Error was '+error.message+' (Code '+error.code+')');
            return true;
        }

        //insert into table category
        var category = [
            <?php
            $i=0;
            foreach($category as $cat){
                if(!empty($cat)) {
                    echo($i > 0 ? "," : "");
                    echo "{
                                'code':'" . $cat['CAT_CODE'] . "',
                                'name':'" . $cat['CAT_NAME'] . "',
                                'desc' :'" . $cat['CAT_DESC'] . "',
                                'syncd' :'" . $cat['SYNCD'] . "'
                                }";
                    $i++;
                }
            }
            ?>
        ];


        //insert into table category
        var item = [
            <?php
            $i=0;
            foreach($item as $itm){
                if(!empty($itm)) {
                    echo($i > 0 ? "," : "");
                    echo "{
                                'itemcode':'" . $itm['ITEM_CODE'] . "',
                                'itemname':'" . $itm['ITEM_NAME'] . "',
                                'itemprice' :'" . $itm['ITEM_PRICE'] . "',
                                'itemimage' :'" . $itm['ITEM_IMAGE'] . "',
                                'supplierComp' :'" . $itm['SUPP_COMPANY'] . "',
                                'cateName' :'" . $itm['CATEGORY_NAME'] . "',
                                'syncd' :'" . $itm['SYNCD'] . "'
                                }";
                    $i++;
                }
            }
            ?>
        ];

        //insert into table supplier
        var supplier = [
            <?php
            $i=0;
            foreach($supplier as $supp){
                if(!empty($supp)) {
                    echo($i > 0 ? "," : "");
                    echo "{
                                'semail':'" . $supp['SUPP_EMAIL'] . "',
                                'sname':'" . $supp['SUPP_NAME'] . "',
                                'saddress' :'" . $supp['SUPP_ADDRESS'] . "',
                                'scompany' :'" . $supp['SUPP_COMPANY'] . "',
                                'sphone' :'" . $supp['SUPP_PHONE'] . "',
                                'scontact' :'" . $supp['SUPP_CONTACT'] . "',
                                 'syncd' :'" . $supp['SYNCD'] . "'
                                }";
                    $i++;
                }
            }
            ?>
        ];


        var db;
        var latest;
        var shortName='POSMart';
        var version='0.1';
        var displayName='POSMart';
        var maxSize = 65536;
        db = openDatabase(shortName,version,displayName,maxSize);

        //select latest SYNCD from category
        db.transaction(function (transaction){
            transaction.executeSql('SELECT * FROM category order by SYNCD DESC LIMIT 1', [], function (transaction,results) {
                var len = results.rows.length, i;
                for (i=0; i < len; i++ ){
                    latest = "<p> The latest category added: " + results.rows.item(i).SYNCD + "</p>";
                    document.querySelector('#latestDate').innerHTML += latest;
                }
            },null );

        });

        //select latest SYNCD from supplier
        db.transaction(function (transaction){
            transaction.executeSql('SELECT * FROM supplier order by SYNCD DESC LIMIT 1', [], function (transaction,results) {
                var len = results.rows.length, i;
                for (i=0; i < len; i++ ){
                    latest = "<p> The latest supplier added: " + results.rows.item(i).SYNCD + "</p>";
                    document.querySelector('#latestDate').innerHTML += latest;
                }
            },null );

        });
        //select latest SYNCD from item
        db.transaction(function (transaction){
            transaction.executeSql('SELECT * FROM item order by SYNCD DESC LIMIT 1', [], function (transaction,results) {
                var len = results.rows.length, i;
                for (i=0; i < len; i++ ){
                    latest = "<p> The latest item added: " + results.rows.item(i).SYNCD + "</p>";
                    document.querySelector('#latestDate').innerHTML += latest;
                }
            },null );

        });


        //select latest SYNCD from supplier
        // db.transaction(function (transaction){
        //     transaction.executeSql('SELECT * FROM sqlite_master WHERE name="supplier" LIMIT 1;', [], function (transaction,results) {
        //         var len = results.rows.length, i;
        //         for (i=0; i < len; i++ ){
        //             latest = "<p> The latest supplier added: " + results.rows.item(i).SYNCD + "</p>";
        //             document.querySelector('#latestDate').innerHTML += latest;
        //         }
        //     },null );
        //
        // });



        function runExample() {
            createDbAndTables();
            getAllTables(getResult);
            getAllTablesFromDB(getResultSetFromTable);

        }

        function createDbAndTables(callback) {
            // var shortName='POSMart';
            // var version='0.1';
            // var displayName='POSMart';
            // var maxSize = 65536;
            // db = openDatabase(shortName,version,displayName,maxSize);
            db.transaction(function(transaction) {
                transaction.executeSql('DROP TABLE category',null,function(){console.log('Drop Succeeded');},function(){console.log('Drop Failed');});
                transaction.executeSql(
                    'CREATE TABLE IF NOT EXISTS category ' +
                    ' (CAT_CODE VARCHAR(20) NOT NULL PRIMARY KEY, ' +
                    ' CAT_NAME VARCHAR(30) DEFAULT NULL, CAT_DESC VARCHAR(256) DEFAULT NULL,'+
                    ' SYNCA varchar(50) DEFAULT NULL, SYNCB varchar(50) DEFAULT NULL, SYNCD datetime DEFAULT CURRENT_TIMESTAMP,' +
                    ' SYNMA varchar(50) DEFAULT NULL, SYNMB varchar(50) DEFAULT NULL, SYNMD datetime DEFAULT NULL);'
                );

                transaction.executeSql('DROP TABLE supplier',null,function(){console.log('Drop Succeeded');},function(){console.log('Drop Failed');});

                transaction.executeSql(
                    'CREATE TABLE IF NOT EXISTS supplier ' +
                    ' (SUPP_EMAIL VARCHAR(30) NOT NULL PRIMARY KEY, ' +
                    ' SUPP_NAME VARCHAR(30) DEFAULT NULL, SUPP_ADDRESS VARCHAR(100) DEFAULT NULL,' +
                    ' SUPP_COMPANY VARCHAR(30) DEFAULT NULL, SUPP_PHONE VARCHAR(15) DEFAULT NULL,' +
                    ' SUPP_CONTACT VARCHAR(15) DEFAULT NULL,' +
                    ' SYNCA varchar(50) DEFAULT NULL, SYNCB varchar(50) DEFAULT NULL, SYNCD datetime DEFAULT CURRENT_TIMESTAMP,' +
                    ' SYNMA varchar(50) DEFAULT NULL, SYNMB varchar(50) DEFAULT NULL, SYNMD datetime DEFAULT NULL);'
                );

                transaction.executeSql('DROP TABLE item',null,function(){console.log('Drop Succeeded');},function(){console.log('Drop Failed');});

                transaction.executeSql(
                    'CREATE TABLE IF NOT EXISTS item ' +
                    ' (ITEM_CODE VARCHAR(20) NOT NULL PRIMARY KEY, ' +
                    ' ITEM_NAME VARCHAR(20) DEFAULT NULL, ITEM_IMAGE LONGBLOB DEFAULT NULL,' +
                    ' ITEM_PRICE DOUBLE DEFAULT NULL, SUPP_COMPANY VARCHAR(30) DEFAULT NULL,' +
                    ' CATEGORY_NAME VARCHAR(20) DEFAULT NULL,' +
                    ' SYNCA varchar(50) DEFAULT NULL, SYNCB varchar(50) DEFAULT NULL, SYNCD datetime DEFAULT CURRENT_TIMESTAMP,' +
                    ' SYNMA varchar(50) DEFAULT NULL, SYNMB varchar(50) DEFAULT NULL, SYNMD datetime DEFAULT NULL);'
                );

                db.transaction(
                    function(transaction) {
                        for (var i = 0; i < category.length; i++) {
                            console.log('Attempting to insert ' + category[i]["code"] + category[i]["name"] + 'and' +  category[i]["name"]);
                            transaction.executeSql(
                                'INSERT INTO category (CAT_CODE, CAT_NAME, CAT_DESC, SYNCD) VALUES (?,?,?,?);',
                                [category[i]["code"], category[i]["name"], category[i]["desc"],category[i]["syncd"]],
                                null,
                                errorHandler

                            );

                        }

                        for (var i = 0; i < supplier.length; i++) {
                            console.log('Attempting to insert ' + supplier[i]["semail"] + ',' + supplier[i]["sname"] + ',' + supplier[i]["saddress"] + ',' + supplier[i]["scompany"] + ',' + supplier[i]["sphone"] + ' and ' + supplier[i]["scontact"]);
                            transaction.executeSql(
                                'INSERT INTO supplier (SUPP_EMAIL, SUPP_NAME, SUPP_ADDRESS, SUPP_COMPANY,SUPP_PHONE, SUPP_CONTACT, SYNCD) VALUES (?,?,?,?,?,?,?);',
                                [supplier[i]["semail"], supplier[i]["sname"],supplier[i]["saddress"],supplier[i]["scompany"],supplier[i]["sphone"],supplier[i]["scontact"],supplier[i]["syncd"]],
                                null,
                                errorHandler
                            );
                        }

                        for (var i = 0; i < item.length; i++) {
                            console.log('Attempting to insert ' + item[i]["itemcode"] + ',' + item[i]["itemname"] + ',' + item[i]["itemprice"] + ',' + item[i]["itemimage"] +   ',' + item[i]["supplierComp"] + ' and ' + item[i]["cateName"]);
                            transaction.executeSql(
                                'INSERT INTO item (ITEM_CODE, ITEM_NAME, ITEM_PRICE,ITEM_IMAGE, SUPP_COMPANY,CATEGORY_NAME,SYNCD) VALUES (?,?,?,?,?,?,?);',
                                [item[i]["itemcode"], item[i]["itemname"], item[i]["itemprice"], item[i]["itemimage"], item[i]["supplierComp"],item[i]["cateName"],item[i]["syncd"]],
                                null,
                                errorHandler
                            );
                        }
                    });
            });


        }// end createDB fx

        function getAllTablesFromDB(callback) {
            db.transaction(function(tx) {
                tx.executeSql('SELECT tbl_name from sqlite_master WHERE type = "table"', [], function(tx, results) {
                    callback(results, processResultSet);
                });
            });
        }


        function getResultSetFromTable(results, callback) {
            var length = results.rows.length;
            var j = 0;
            for (var i = 0; i < length; i++) {
                db.transaction(function(tx) {
                    var k=0,tblname=results.rows[j++].tbl_name;
                    tx.executeSql('SELECT * FROM ' + tblname , [], function(tx, results) {
                        callback(tblname,results);
                    });
                });
            }

        }


        //table

        function processResultSet(tblname,results) {
            if(tblname=="category"){
                console.log('----------------------'+tblname)
                var len = results.rows.length;
                var tbl = document.createElement('table');
                var trTblName = document.createElement('tr');
                var thTblName = document.createElement('th');
                thTblName.innerHTML = tblname;
                trTblName.colSpan = 2;
                trTblName.appendChild(thTblName);
                tbl.appendChild(trTblName);

                var trHeader = document.createElement('tr');
                var th1 = document.createElement('th');
                th1.innerHTML = 'Category Code';
                var th2 = document.createElement('th');
                th2.innerHTML = 'Category Name';
                var th3 = document.createElement('th');
                th3.innerHTML = 'Description';
                // var th4 = document.createElement('th');
                // th4.innerHTML = 'SYNCD';
                trHeader.appendChild(th1);
                trHeader.appendChild(th2);
                trHeader.appendChild(th3);
                //trHeader.appendChild(th4);
                tbl.appendChild(trHeader);

                for (var i = 0; i < category.length; i++) {
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    td1.innerHTML = results.rows[i].CAT_CODE;
                    var td2 = document.createElement('td');
                    td2.innerHTML = results.rows[i].CAT_NAME;
                    var td3 = document.createElement('td');
                    td3.innerHTML = results.rows[i].CAT_DESC;
                    // var td4 = document.createElement('td');
                    // td4.innerHTML = results.rows[i].SYNCD;
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    //tr.appendChild(td4);
                    tbl.appendChild(tr);
                }
                var body = document.getElementsByTagName('body')[0];
                body.appendChild(tbl);
                body.appendChild(document.createElement('br'));
                body.appendChild(document.createElement('br'));
                //body.appendChild(document.createElement('hr'));


            }
            else if(tblname=="item"){
                console.log('----------------------'+tblname)
                var len = results.rows.length;
                var tbl = document.createElement('table');
                var trTblName = document.createElement('tr');
                var thTblName = document.createElement('th');
                thTblName.innerHTML = tblname;
                trTblName.colSpan = 2;
                trTblName.appendChild(thTblName);
                tbl.appendChild(trTblName);

                var trHeader = document.createElement('tr');
                var th1 = document.createElement('th');
                th1.innerHTML = 'Item Code';
                var th2 = document.createElement('th');
                th2.innerHTML = 'Item Name';
                var th3 = document.createElement('th');
                th3.innerHTML = 'Item Price';
                var th4 = document.createElement('th');
                th4.innerHTML = 'Item Image';
                var th5 = document.createElement('th');
                th5.innerHTML = 'Supplier Company';
                var th6 = document.createElement('th');
                th6.innerHTML = 'Category Name';
                // var th7 = document.createElement('th');
                // th7.innerHTML = 'SYNCD';
                trHeader.appendChild(th1);
                trHeader.appendChild(th2);
                trHeader.appendChild(th3);
                trHeader.appendChild(th4);
                trHeader.appendChild(th5);
                trHeader.appendChild(th6);
                //trHeader.appendChild(th7);
                tbl.appendChild(trHeader);

                for (var i = 0; i < item.length; i++) {
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    td1.innerHTML = results.rows[i].ITEM_CODE;
                    var td2 = document.createElement('td');
                    td2.innerHTML = results.rows[i].ITEM_NAME;
                    var td3 = document.createElement('td');
                    td3.innerHTML = results.rows[i].ITEM_PRICE;
                    var td4 = document.createElement('td');
                    td4.innerHTML = results.rows[i].ITEM_IMAGE;
                    var td5 = document.createElement('td');
                    td5.innerHTML = results.rows[i].SUPP_COMPANY;
                    var td6 = document.createElement('td');
                    td6.innerHTML = results.rows[i].CATEGORY_NAME;
                    // var td7 = document.createElement('td');
                    // td7.innerHTML = results.rows[i].SYNCD;
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    tr.appendChild(td5);
                    tr.appendChild(td6);
                    //tr.appendChild(td7);
                    tbl.appendChild(tr);
                }
                var body = document.getElementsByTagName('body')[0];
                body.appendChild(tbl);
                body.appendChild(document.createElement('br'));
                //body.appendChild(document.createElement('hr'));
            }
            else{
                console.log('----------------------'+tblname)
                var len = results.rows.length;
                var tbl = document.createElement('table');
                var trTblName = document.createElement('tr');
                var thTblName = document.createElement('th');
                thTblName.innerHTML = tblname;
                trTblName.colSpan = 2;
                trTblName.appendChild(thTblName);
                tbl.appendChild(trTblName);

                var trHeader = document.createElement('tr');
                var th1 = document.createElement('th');
                th1.innerHTML = 'Supplier Email';
                var th2 = document.createElement('th');
                th2.innerHTML = 'Supplier Name';
                var th3 = document.createElement('th');
                th3.innerHTML = 'Supplier Address';
                var th4 = document.createElement('th');
                th4.innerHTML = 'Company Name';
                var th5 = document.createElement('th');
                th5.innerHTML = 'Phone Number';
                var th6 = document.createElement('th');
                th6.innerHTML = 'Contact Person';
                // var th7 = document.createElement('th');
                // th7.innerHTML = 'SYNCD';
                trHeader.appendChild(th1);
                trHeader.appendChild(th2);
                trHeader.appendChild(th3);
                trHeader.appendChild(th4);
                trHeader.appendChild(th5);
                trHeader.appendChild(th6);
               // trHeader.appendChild(th7);
                tbl.appendChild(trHeader);

                for (var i = 0; i < supplier.length; i++) {
                    var tr = document.createElement('tr');
                    var td1 = document.createElement('td');
                    td1.innerHTML = results.rows[i].SUPP_EMAIL;
                    var td2 = document.createElement('td');
                    td2.innerHTML = results.rows[i].SUPP_NAME;
                    var td3 = document.createElement('td');
                    td3.innerHTML = results.rows[i].SUPP_ADDRESS;
                    var td4 = document.createElement('td');
                    td4.innerHTML = results.rows[i].SUPP_COMPANY;
                    var td5 = document.createElement('td');
                    td5.innerHTML = results.rows[i].SUPP_PHONE;
                    var td6 = document.createElement('td');
                    td6.innerHTML = results.rows[i].SUPP_CONTACT;
                    // var td7 = document.createElement('td');
                    // td7.innerHTML = results.rows[i].SYNCD;
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);
                    tr.appendChild(td5);
                    tr.appendChild(td6);
                    //tr.appendChild(td7);
                    tbl.appendChild(tr);
                }
                var body = document.getElementsByTagName('body')[0];
                body.appendChild(tbl);
                body.appendChild(document.createElement('br'));
                body.appendChild(document.createElement('br'));
                //body.appendChild(document.createElement('hr'));
            }

        }
        function getAllTables(callback) {
            db.transaction(function(tx) {
                tx.executeSql('SELECT tbl_name from sqlite_master WHERE type = "table" ', [], function(tx, results) {
                     callback(results, processResult);
                    //console.log("callback: " + ret);
                });
            });
        }

        function getResult(results, callback) {
            var length = results.rows.length;
            var j = 0;
            for (var i = 0; i < length; i++) {
                db.transaction(function(tx) {
                    var k=0,tblname=results.rows[j++].tbl_name;
                    tx.executeSql('SELECT SYNCD FROM ' + tblname  , [], function(tx, results) {
                        callback(tblname,results);
                    });
                });
            }

        }

        //console.log("category:" + catDate);

        function processResult(tblname,results) {
            if(tblname=="category"){
                var i = category.length - 1;
                catDate = results.rows[i].SYNCD;
                console.log("Last category date:" + catDate);
                var lastCat = "<p> Last category date: " +catDate+ "</p>";
                document.querySelector('#lastDate').innerHTML += lastCat;
                return catDate;


            }
            else if(tblname=="item"){
                var i = item.length - 1;
                itemDate = results.rows[i].SYNCD;
                console.log("Last item date:" + itemDate);
                var lastItem = "<p> Last item date: " +itemDate+ "</p>";
                document.querySelector('#lastDate').innerHTML += lastItem;
                return itemDate;
            }
            else{
                var i = supplier.length - 1;
                supplierDate = results.rows[i].SYNCD;
                console.log("Last supplier date:" + supplierDate);
                var lastSupp = "<p> Last supplier date: " +supplierDate+ "</p>";
                document.querySelector('#lastDate').innerHTML += lastSupp;
                return supplierDate;

        }}




    </script>
</head>

<body onload="runExample()">

<div id="latestDate" name="latestDate"><h1>Latest Datetime from PhpMyAdmin:</h1></div>
<br><br>
<div id="lastDate" name="lastDate"><h1>Latest Datetime from Web SQL:</h1></div>
<br><br>
</body>
</html>