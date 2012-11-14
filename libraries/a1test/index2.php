<?php
/*
 * TO   MAKE    this code usable for your own system, first goto Connection/connection.php and put your database information
 * second , edit the sql in teh Document collection.php takeDocumentsFromDatabase();
 * 
 */
        include_once ('Collection/DocumentCollection.php');
        $dc=new DocumentCollection();
        $dc->takeDocumentsFromDatabase();//sql should be corrected to select articles
        //$dc->printAllDocuments();
        //print_r($dc->getScores(1));die();
//        $result=$dc->getRelatedDocumentsId(2);
//        echo "<br/>finall result is :";
//        print_r($result);
        $dc->storeRelationOfAll();
        echo $dc->getGroupId(2);
?>
