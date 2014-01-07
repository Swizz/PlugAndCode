<?php 
    function connect_bdd() {
        try {
            $bdd = new PDO(BDDstring, BDDpseudo, BDDpass);

            return $bdd;
        } 
        catch ( Exception $e ) {
            echo "Connection à la base donnée impossible : ", $e->getMessage();
            return false;
        }
    }
