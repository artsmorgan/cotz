<?

/**
*   Converts a CSV file into an array
*   NOTE: file does NOT have to have .csv extension
*   
*   $file - path to file to convert (string)
*   $delimiter - field delimiter (string)
*   $first_line_keys - use first line as array keys (bool)
*   $line_lenght - set length to retrieve for each line (int)
*/

class CsvReader {


    public static function CSVToArray($file, $delimiter = ',', $first_line_keys = true, $line_length = 2048){

        // file doesn't exist
        // if( !file_exists($file) ){
        //     echo $file; 
        //     die('Not file found');
        // }

        // open file
        $fp = fopen($file, 'r');

        // add each line to array
        $csv_array = array();
        while( !feof($fp) ){

            // get current line
            $line = fgets($fp, $line_length);

            // line to array
            $data = str_getcsv($line, $delimiter);

            // keys/data count mismatch
            if( isset($keys) && count($keys) != count($data) ){

                // skip to next line
                continue;

            // first line, first line should be keys
            }else if( $first_line_keys && !isset($keys) ){

                // use line data for keys
                $keys = $data;

            // first line used as keys
            }else if($first_line_keys){

                // add as associative array
                $csv_array[] = array_combine($keys, $data);

            // first line NOT used for keys
            }else{

                // add as numeric array
                $csv_array[] = $data;

            }

        }

        // close file
        fclose($fp);

        // nothing found
        if(!$csv_array){
            return array();
        }

        // return csv array
        return $csv_array;

    } // CSVToArray()
}




?>