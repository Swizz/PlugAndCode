<?php 
    function connect_bdd() {
        try {
            $bdd = new PDO(BDDstring, BDDpseudo, BDDpass);

            return $bdd;
        } 
        catch ( Exception $e ) {
            echo "Connection � la base donn�e impossible : ", $e->getMessage();
            return false;
        }
    }
