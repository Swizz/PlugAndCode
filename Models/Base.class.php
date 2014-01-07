<?php
/* Copyright (c) 2014 GERODEL Quentin (aka Swizz540)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. */

    require_once('Utils/bdd_connect.php');

    function _s($term) {
        return is_int($term) ? $term : "'$term'";
    }

    abstract class Base {
        public static $PRIMARYKEY = "id";
        private $fetch;
        
        public function __construct($fetch=False) {
            $this->fetch = $fetch;

            foreach($this as $attr => $value) {
                if($attr != "fetch") {
                    $this->$attr = is_numeric($value) ? $value+0 : $value;
                }
            }
        }
        
        public static function is_multikey() {
            $className = get_called_class();
            $id = $className::$PRIMARYKEY;
            return (is_array($id));
        } 

        public function id() {
            $className = get_called_class();
            $id = $className::$PRIMARYKEY;

            if(self::is_multikey()) {
                $id2 = "";
                foreach ($id as $pkey) {
                   $id2 .= $this->$pkey .",";
                }

                $id = "(" . substr($id2, 0, strlen($id2) - 1) . ")";
            }
            else {
                $id = $this->$id;
            }

            return $id;
        }

        private static function createIdFilter($id) {
            $className = get_called_class();
            $request = "WHERE ";

            if(self::is_multikey()) {
                $i=0;
                foreach($className::$PRIMARYKEY as $pkey) {
                    $request .= $pkey ."=". _($id[$i]) . " AND ";
                    $i++;
                }

                $request = substr($request, 0, strlen($request) - 5);
            }
            else {
                $request .= $className::$PRIMARYKEY . "=" . _($id);
            }

            return $request;
        }

        private static function prepareGet($filters) {
            $className = get_called_class();
            $bdd = connect_bdd();

            $filters = ($filters != " ") ? " " . $filters : $filters;
  
            $query = "SELECT * FROM $className $filters;";
            
            $query = $bdd->prepare($query);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_CLASS,
                                 $className,
                                 array(True));
            $bdd = null;
            return $query;
        }

        public static function getAll($filters=" ") {
            $query = self::prepareGet($filters);
            $responses = $query->fetchAll();
        
            return $responses;
        }

        public static function get($id=null, $filters=" ") {
            $className = get_called_class();
            $filters = (is_null($id)) ? $filters : self::createIdFilter($id);

            $query = self::prepareGet($filters);
            $response = $query->fetch();

            return $response;
        }

        public function delete() {
            $className = get_called_class();
            $bdd = connect_bdd();
            $id = $className::$PRIMARYKEY;

            $query = "DELETE FROM $className ". self::createIdFilter($id) .";";
            $query = $bdd->prepare($query);
            $query->execute();
            $bdd = null;
        }

        public function save() {
            $className = get_called_class();
            $bdd = connect_bdd();
            
            if($this->fetch) {
                $query = "UPDATE $className SET ";
            
                foreach($this as $attr => $value) {
                    if($attr != "fetch") {
                        if (!is_null($value) && isset($value)) {
                            $query .= "$attr=" ._s($value).", ";
                        }
                    }
                }

                $id = $className::$PRIMARYKEY;
                $query = substr($query, 0, strlen($query) - 2) . " ";
                $query .= self::createIdFilter($id) .";";
            
                $query = $bdd->prepare($query);
                $query->execute();
            }
            else {
                $query = "INSERT INTO $className ";
                $query1 = "(";
                $query2 = "(";

                foreach($this as $attr => $value) {
                    if($attr != "fetch") {
                        if (!is_null($value) && isset($value)) {
                            $query1 .= "$attr,";
                            $query2 .= _s($value).",";
                        }
                    }
                }
        
                $query1 = substr($query1, 0, strlen($query1) - 1) . ")";
                $query2 = substr($query2, 0, strlen($query2) - 1) . ")";

                $query .= "$query1 VALUES $query2;";
                
                $query = $bdd->prepare($query);
                $query->execute();
            
                $id = $className::$PRIMARYKEY;

                if(!is_array($id) && is_null($this->$id)) {
                    $query = "SELECT max($id) AS id FROM $className;";
                    $query = $bdd->query($query);
                    $result = $query->fetch();
                    $this->$id = $result["id"];
                }
                $this->fetch = True;
            }  
            $bdd = null;
        }

        public function log() {
            echo "<pre>";
            echo print_r($this);
            echo "</pre>";
        }
    }
