<?php

class Connection{

	static public function connect(){

		$link = new PDO("mysql:host=localhost;dbname=plotdmco_devel_db",
			"plotdmco_devel_usr",
			"Da.7E_;ToX#=");

		$link->exec("set names utf8");
		$link->exec("set time_zone = 'America/Santiago'");

		return $link;

	}
        
    static public function connect_plotdm_beta(){

		$link = new PDO("mysql:host=localhost;dbname=plotdmco_db_beta",
			"plotdmco_dev",
			"aUv;?3GW8wl^bHJH_n");

		$link->exec("set names utf8");
		$link->exec("set time_zone = 'America/Santiago'");

		return $link;

	}
        
    static public function connect_production(){

		$link = new PDO("mysql:host=localhost;dbname=plotdmco_db",
			"plotdmco_root",
			"lkeg{uy&0=ykcfLj3;");

		$link->exec("set names utf8");
		$link->exec("set time_zone = 'America/Santiago'");
		$link->exec("SET SESSION TRANSACTION READ ONLY"); //set to read only

		return $link;

	}

	static public function connect_super_ro(){

        $link = new PDO("mysql:host=localhost;dbname=plotdmco_devel_db",
            "plotdmco",
            "ElfYH8lnY4];35");

		//$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		//$link->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

        $link->exec("set names utf8");
        $link->exec("set time_zone = 'America/Santiago'");
        $link->exec("SET SESSION TRANSACTION READ ONLY"); //set to read only
		//$link->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

        return $link;

    }

    static public function connect_super(){

        $link = new PDO("mysql:host=localhost;dbname=plotdmco_devel_db",
            "plotdmco",
            "ElfYH8lnY4];35");

        $link->exec("set names utf8");
        $link->exec("set time_zone = 'America/Santiago'");
        //$link->exec("SET SESSION TRANSACTION READ ONLY"); //set to read only

        return $link;

    }
}