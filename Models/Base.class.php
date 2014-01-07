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

    abstract class Base {
        protected $id;
        public $name;
        private $fetch;

        public function __construct($fetch=False) {
            $this->fetch = $fetch;
        }

        public function id() {
            return $this->id;
        }

        private static function prepareGet($filters) {
            $className = get_called_class();
            $bdd = connect_bdd();

            $filters = ($filters != " ") ? " " . $filters : $filters;
  
            $query = "SELECT * FROM $className $filters;";
   
            $query = $bdd->prepare($query);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_CLASS
                                 | PDO::FETCH_PROPS_LATE,
                                 $className,
                                 array(True));
            return $query;
        }

        public static function getAll($filters=" ") {
            $query = self::prepareGet($filters);
            $responses = $query->fetchAll();

            return $responses;
        }

        public static function get($id=null, $filters=" ") {
            $filters = (is_null($id)) ? $filters : "WHERE id=$id";

            $query = self::prepareGet($filters);
            $response = $query->fetch();

            return $response;
        }

        public function extend($type, $id=null) {
            $extend_id = $type . "_id";

            if (!$id) {
                if(isset($this->$extend_id)) {
                    return $type::get($this->$extend_id);
                }
                return array();
            }
            else {
                return $type::get($id);
            }
        }

        public function save() {
            $className = get_called_class();
            $bdd = connect_bdd();

            if($this->fetch) {
                $query = "UPDATE $className SET ";

                foreach($this as $attr => $value) {
                    if($attr != "fetch" && $attr != "id") {
                        $query .= "$attr='$value', ";
                    }
                }

                $query = substr($query, 0, strlen($query) - 2) . " ";
                $query .= "WHERE id=" . $this->id . ";";
                echo $query;

                $query = $bdd->prepare($query);
                $query->execute();
            }
            else {
                $query = "INSERT INTO $className ";
                $query1 = "(";
                $query2 = "(";

                foreach($this as $attr => $value) {
                    if($attr != "fetch" && $attr != "id") {
                        $query1 .= "$attr,";
                        $query2 .= "'$value',";
                    }
                }

                $query1 = substr($query1, 0, strlen($query1) - 1) . ")";
                $query2 = substr($query2, 0, strlen($query2) - 1) . ")";

                $query .= "$query1 VALUES $query2;";

                $query = $bdd->prepare($query);
                $query->execute();

                $this->id = $bdd->lastInsertId();
                $this->fetch = True;
            }
        }
    }
