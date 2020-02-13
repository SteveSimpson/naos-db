<?php
/**
 * @link
 * @copyright
 * @license
 */

namespace app\commands;

use app\models\db\Host;
use app\models\db\Pps;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\db\Network;

/**
 *
 */
class UtilController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        echo "Usage:\n";
        
        return ExitCode::OK;
    }
    
    /**
     * This will insert or update hosts in the database; first field of file must be hostname
     * Any other fields will be added to the host
     * 
     * @param string $delimiter
     * @param string $file
     * @return number
     */
    public function actionImportHosts($delimiter=false, $file=false)
    {
        $host = new Host();
        $reference = $host->attributes;
        $stop = false;
        
        if (!$delimiter || !$file) {
            echo "Usage: ./yii util/import-hosts DELIMITER FILE\n";
            echo "File will be parsed using supplied DELIMTER\n\n";
            
            echo "This will insert or update hosts in the database; first field must be hostname.\n";
            echo "Fields:\n";

            foreach ($reference as $key=>$value) {
                echo "\t" . $key ."\n";
            }
            //print_r($host->attributes);
            return ExitCode::OK;
        }
        
        if (!is_readable($file)) {
            echo "Cannot read file.\n";
            return ExitCode::OSFILE;
        }
        
        $lines = explode("\n", file_get_contents($file));
        
        $fields = false;
        foreach ($lines as $line) {
            if(trim($line) != "") {
                if ($fields) {
                    $data = explode($delimiter, $line);
                    
                    if(!is_array($data) || (count($data) != count($fields))) {
                        echo "Field count does not match.\n";
                        return ExitCode::DATAERR;
                    }
                    
                    $host = Host::findOne(['hostname' => trim($data[0])]);
                    
                    if ($host) {
                        echo "Updating Host: ";
                    } else {
                        $host = new Host();
                        echo "Creating Host: ";
                    }
                    echo trim($data[0]) . "... ";
                    
                    foreach($fields as $key=>$field) {
                        $host->$field = trim($data[$key]);
                    }
                    
                    if($host->save()) {
                        echo "done\n";
                    } else {
                        echo "failed\n";
                        if ($host->hasErrors()) {
                            print_r($host->errors);
                            return ExitCode::DATAERR;
                        }
                    }
                    
                } else {
                    // first line should give us the db fields
                    $fields = explode($delimiter, $line);
                    if (!is_array($fields) || !count($fields) || $fields[0] != 'hostname') {
                        echo "First field must be hostname so that the host can be identied.\n";
                        return ExitCode::DATAERR;
                    }
                    
                    foreach($fields as $key=>$field) {
                        $field = trim($field);
                        $fields[$key] = $field;
                        
                        if(!array_key_exists($field, $reference)) {
                            echo "The following field does not exist: " . $field . "\n";
                            $stop = true;
                        }
                    }
                    if($stop) {
                        return ExitCode::DATAERR;
                    }
                    echo "Fields: " . implode(" ", $fields). "\n";
                }
            }
        }
        return ExitCode::OK;
    }
}