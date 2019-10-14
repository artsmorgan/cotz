<?php 
class GenericReader {

    public static function process($file){
		$result = array();
		$fp = fopen($file,'r');
		if (($headers = fgetcsv($fp, 0, "\t")) !== FALSE)
		  if ($headers)
		    while (($line = fgetcsv($fp, 0, "\t")) !== FALSE) 
		      if ($line)
		        if (sizeof($line)==sizeof($headers))
		          $result[] = array_combine($headers,$line);
		fclose($fp);
		return $result;
	}
	
}		