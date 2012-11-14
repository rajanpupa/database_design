<?php
/*
 * Author rajan , this is the Document collection class where  a collection of articles needs 
 * to be passed and then relatedness score can be found with one document to other document
 */
    include_once('DataBase/database_class.php');
    class DocumentCollection{
        public $Docs=array();
        
        public function addDocument($article){
            /*adds single Document where $article has two elements id, and description*/
            $this->Docs[$article['id']]=$article['description'];
        }
        public function addDocuments($result){
            /*$result is a resultset of articles that needs to be added*/
            $row;
            $i=0;
            while($row=mysql_fetch_array($result)){
                    //$id[$i]=$row['id'];
                    $this->Docs[$row['id']]=$row['description'];//ie id=>description
                    //echo $docs[$i];
                    $i++;
            }
            //echo "the number of articles is ".$i;
        }
        public function takeDocumentsFromDatabase(){
             $db=new DataBase();
            $sql="SELECT id, description FROM manual_news where 
                submitted_date>=DATE_SUB(CURDATE(), INTERVAL 2 DAY) order by submitted_date asc";
            echo $sql;
            $result=$db->execute_query_return_result($sql);
            $this->addDocuments($result);
        }
        
        public function printAllDocuments(){
            //for debugging
           // print_r($this->Docs);
            echo "<br/><table>";
            foreach($this->Docs as $id=>$description){
                printf("<tr><td style='border:solid;'>%d</td><td style='border:solid;'>%s</td></tr>",$id,$description);
            }
            echo "</table>";
        }
        public function getBM25Scores($articleId){
            /*
             * returns bm25 Score of $articleId with all other articleId's , array
             */
            $query=$this->Docs[$articleId];
            //$results=array();
            preg_match_all('/\w+/', $query, $matches);
                    $queryTerms = $matches[0];//array of words
                   // print_r($queryTerms);
                   // die();
                    //echo "<br/>We are querying <br/> ".$query."<br/>";
                   $collection = array('terms' => array(), 'length' => 0, 'documents' => array());
                            foreach($this->Docs as $docID => $doc) {
                                            preg_match_all('/\w+/', $doc, $matches);
                                            // store the document length
                                            $collection['documents'][$docID] = count($matches[0]);

                                            foreach($matches[0] as $match) {
                                                            if(!isset($collection['terms'][$match])) {
                                                                            $collection['terms'][$match] = array();
                                                            }
                                                            if(!isset($collection['terms'][$match][$docID])) {
                                                                            $collection['terms'][$match][$docID] = 0;
                                                            }
                                                            $collection['terms'][$match][$docID]++;
                                                            $collection['length']++;
                                            }        
                            }
                            $collection['averageLength'] = $collection['length']/count($collection['documents']);


                                   // echo "The resulting scores are:<br/>";
                                    $r = $this->bm25Weight($queryTerms, $collection);
                                    arsort($r);
                                    
                                    //print_r("<br/>".count($r)."returning : ".$r."<br/>");//
                                    //print_r($r);
                                 return $r;//return $articleId=>$score
            
        }
        function bm25Weight($query, $collection, $tfWeight = 1.2, $dlWeight = 0.75) {
            $docScores = array();
            $count = count($collection['documents']);
            foreach($query as $term) {
                    $df = count($collection['terms'][$term]);
                    foreach($collection['terms'][$term] as $docID => $tf) {
                            $docLength = $collection['documents'][$docID];
                            $idf = log($count/$df);
                            $num = ($tfWeight + 1) * $tf;
                            $denom = $tfWeight
                                    * ((1 - $dlWeight) + $dlWeight *
                                            ($docLength / $collection['averageLength']))
                                    + $tf;
                            $score = $idf * ($num/$denom);
                            $docScores[$docID] = isset($docScores[$docID]) ?
                                                    $docScores[$docID] + $score : $score;
                    }
            }
            return $docScores;
    }
    
        public function getRelatedDocumentsId($articleId){
            /*Returns array of article id and score with that article, most highest being with itself*/
            //echo ("\n<br/>the article is ".$articleId); ALGORITHM = BM25
            $related=array();
            $threshold=10.0;
            $sc=$this->getBM25Scores($articleId);
            //echo "scores=";
            //print_r($sc);
            //echo "<br/> the top score is: ";
            foreach($sc as $i=>$val){
                $threshold=0.6*$val;
                break;
            }
            
            echo"<br/>The thershold is :".$threshold."<br/>";
            foreach($sc as $id=>$score){
                if($score>$threshold){
                    $related[$id]=$score;
                }else{
                    break;
                }
            }
            //print_r($related);
            return $related;
        }
       public function storeRelationOfAll(){
           foreach($this->Docs as $id=>$description){
               $this->storeRelationOf($id);
           }
       }
        public function storeRelationOf($articleId){
      /*
             * calculated relatedness based on bm25 scores and updates the database
             */
            $result=$this->getRelatedDocumentsId($articleId);
            
            foreach($result as $id=>$score){
                if($id==$articleId){
                    continue;
                }else if(!$this->isPresentInRelated($articleId)){
                    //updates all tables for this relation
                    $this->updateTableFromBm25($articleId, $id, $score);
                }
            }
            echo "updated table related: ";
        }
        private function updateTableFromBm25($articleId,$id,$score){
            $db=new DataBase();
            $query=("insert into related values (".$articleId.",".$id.",".$score.");");
                    $db->execute_query($query);
                    $groupId=$this->getGroupId($articleId);
                    echo "here1".$groupId;
                    if($groupId<1){
                        $groupId=$this->getGroupId($id);
                        if($groupId<1){
                            $query=("insert into related_group values ('',".$articleId.");");
                            echo $query;
                            $db->execute_query($query);
                            $groupId=$this->getGroupId($articleId);
                            $query="insert into related_group values (".$groupId.",".$articleId.")";
                            $db->execute_query($query);
                        }else{
                            $query="insert into related_group values(".$groupId.",".$articleId.")";
                            $db->execute_query($query);
                        }
                    }else{
                        $query="insert into related_group values (".$groupId.",".$id.")";
                        $db->execute_query($query);
                    }
        }
        private function isPresentInRelated($articleId){
            $db=new DataBase();
            $query="select count(*) from related where main_id=".$articleId;//." or related_id=".$articleId;
            $result=$db->execute_query_return_result($query);
            $row=mysql_fetch_array($result);
            if($row[0]>0){
                return true;
            }else{
                return false;
            }
        }
        public function getGroupId($articleId){
            $id=-1;
            $db=new DataBase();
            $query="select group_id from related_group where article_id =".$articleId;
           $result=$db->execute_query_return_result($query);
           $row=mysql_fetch_array($result);
           if($row['group_id']>0){
               $id=$row[0];
           }
           return $id;
        }
    }

?>