<?php
namespace LimeTrail\Bundle\Command\QuickBase;

use DOMDocument;
use DOMXPath;

class QuickBaseWeb
{
    public $username = '';
    public $password = '';
    public $dbpass = '';
    public $realm = '';
    public $urlnav = '';
    public $tableId = 'VR_bfngn7tvg_1002789';
// Create temp file to store cookies
  public $cookieJar = '';
    public $host = '';
    public $loginReferer = '';
    private $dbhost = null;
    private $dbuser = null;
    protected $timeout = 180;
// The User-Agent string to send
  public $userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5";

    public function __construct($un, $pw, $realm, $dbpass = null, $dbhost, $dbuser)
    {
        //echo "construct\n";
        $this->dbhost = $dbhost;

        $this->dbuser = $dbuser;

        if ($un) {
            $this->username = $un;
        }
        if ($dbpass) {
            $this->dbpass = $dbpass;
        }
        if ($pw) {
            $this->password = $pw;
        } else {
            $pword = $this->RetrievePassword();
            $this->password = $pword[1];
        }
        if ($realm) {
            $this->realm = $realm;
            $this->host = $this->realm.'.'."quickbase.com";
        } else {
            $this->host = "quickbase.com";
        }
        $this->cookieJar = dirname(__FILE__).'/cookiez_.tmp';
        $this->loginReferer = 'https://'.$this->host.'/db/main?a=SignIn&_c=mkhkad';
    }

    public function Login()
    {
        echo "login\n";
        $post_data = array();
        $post_data['loginid'] = $this->username;
        $post_data['password'] = $this->password;
        $post_data['SignIn'] = "";
        $postthis = http_build_query($post_data);

    // URL to login page
    // Create the cURL handle for login
    $ch = curl_init('https://'.$this->host.'/db/main?a=signin&what=');

    // Set connection meta
    curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postthis);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    // Set header-related options
    curl_setopt($ch, CURLOPT_REFERER, $this->loginReferer);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);

    // Set connection meta
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1); // debug headers sent


        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); //stop if an error occurred

    // Execute the request
    if (!$result = curl_exec($ch)) {
        $error = curl_error($ch);

        curl_close($ch);

        return $error;
       //exit("ERROR: scrape request failed: " . curl_error($ch));
    }
    // Output the result
    $resource = fopen('qbpage.html', 'w');
        fwrite($resource, $result);
        fclose($resource);
    //echo $result;
    $info = curl_getinfo($ch);
        curl_close($ch);

        $is_expired = $this->TestPasswordExpiry($result);

        if ($is_expired) {
            $this->NewPassword($result);
        } else {
            return $info['size_download'];
        }
    }

    public function GetPasswordForm($page)
    {
        echo "getpasswordform\n";
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;

    //setup xpath
    $xpath = new DOMXpath($doc);

        $xquery = "//form[@name='mainform']";
        $formnodes = $xpath->query($xquery);
        $form = $formnodes->item(0);

        $params = array( 'urlaction' => $form->getAttribute('action'));

        $xquery = ".//input[@name]";
        $inputs = $xpath->query($xquery, $form);

        foreach ($inputs as $input) {
            $params[$input->getAttribute('name')] = $input->getAttribute('value');
        }

        return $params;
    }

    public function NewPassword($page)
    {
        echo "newpassword(page)\n";
        $post_data = $this->GetPasswordForm($page);

        $urlpart = $post_data['urlaction'];
        array_shift($post_data);

    //get new password
    $pword = $this->RetrievePassword();

    // max rows is 12 so we can't exceed that number
    if ($pword[0] > 12) {
        $pword[0] = 0;  // if it is at 12 reset to 0 becuase the function RetrieveNextPassword
      // will increment by 1 before issuing the SQL statement
    }

        if ($this->RetrieveNextPassword($pword[0]) === true) {
            $pword = $this->RetrievePassword();
            $this->password = $pword[1];
        } else {
            exit("Mysql couldn't update to new password");
        }

        $post_data['password2'] = $this->password;
        $post_data['password'] = $this->password;
        $postthis = http_build_query($post_data);

    // URL to login page
    // Create the cURL handle for login
    $ch = curl_init('https://'.$this->host.'/db/'.$urlpart);

    // Set connection meta
    curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postthis);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

    // Set header-related options
    curl_setopt($ch, CURLOPT_REFERER, $this->loginReferer);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);

    // Set connection meta
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1); // debug headers sent

    
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); //stop if an error occurred


    // Execute the request
    if (!$result = curl_exec($ch)) {
        // Output the result
    $resource = fopen('try-reset-password.html', 'w');
        fwrite($resource, $result);
        fclose($resource);
        exit("ERROR: request failed: ".curl_error($ch));
    }
    // Output the result
    $resource = fopen('try-reset-password.html', 'w');
        fwrite($resource, $result);
        fclose($resource);
    //echo $result;

    curl_close($ch);

        $this->Login();
    }

    public function GetTable($url)
    {
        // echo "gettable\n";
   // Create the cURL handle for login
   $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html'));

   // Set header-related options
   curl_setopt($ch, CURLOPT_REFERER, $this->loginReferer);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);

   // Set connection meta
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   //curl_setopt($ch, CURLOPT_HEADER, 1); // debug headers sent

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); //stop if an error occurred


   // Execute the request
   if (!$result = curl_exec($ch)) {
       exit("ERROR: scrape request failed: ".curl_error($ch));
   }
   // Output the result
   //$resource = fopen('qb-'.urlencode($url).'.html', 'w');
   //     fwrite($resource, $result);
   //     fclose($resource);
   //echo $result;

   $curlinfo = curl_getinfo($ch);

        preg_match_all('/^Location:(.*)$/mi', $result, $matches);

        if (!empty($matches[1])) {
            $this->BuildTableIdFromUrl($matches[1]);
        } else {
            $this->BuildTableIdFromUrl($curlinfo["url"]);
        }

        //echo curl_errno($ch).'-'.curl_error($ch);
        curl_close($ch);

        return $result;
    }

    private function BuildTableIdFromUrl($url)
    {
        //echo "buildtableidfromurl\n";
        if (preg_match('~/db/(?P<database>\w+)\?.*(?:qid=)(?P<record>-?\d+)~', $url, $matches) === 1) {
            $this->tableId = "VR_".$matches["database"]."_".$matches["record"];
        }
    }

    public function TestPasswordExpiry($page)
    {
        echo "TestPasswordExpiry(page)\n";
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;

    //setup xpath
    $xpath = new DOMXpath($doc);

        $xquery = "//title";
        $nodes = $xpath->query($xquery);
        $title = $nodes->item(0);

        if ($title->nodeValue == "Password Expired") {
            return true;
        } else {
            return false;
        }
    }

    public function ParseHTML($page)
    {
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;

        //setup xpath
        $xpath = new DOMXpath($doc);
        //get table by its ID
        $table = $doc->getElementById($this->tableId);

        //find the table row holding the column headers
        //only nodes having <span class=ColumnHeading>value</span> contain column headers
        $xquery = ".//span[@class='ColumnHeading']";
            $headers = $xpath->query($xquery, $table);
        //$i = $headers->length;
        //print $i."\n";
        $headerArray = array();
            foreach ($headers as $head) {
                $node = $head->nodeValue;
                if (!empty($node)) {
                    trim($node);
             //print $node;
             array_push($headerArray, $node);
                }
            }
        //print "\n";
        //print implode("\n",$headerArray);
        //print_r ($headerArray);
        //print 'headers:'.count($headerArray)."\n";

        $xquery = ".//tr[@canview='true']";
            $rows = $xpath->query($xquery, $table);
        //$Rows = array();
        $allData = array();
        
        foreach ($rows as $row) {
            $recordId = $row->getAttribute('id');
            $recordId = str_replace('rid', '', $recordId);
            
            $aRow = $xpath->query(".//td[not(@class='icr')]", $row);
            $rowdata = array();
            
            foreach ($aRow as $node) {
                $val = $node->nodeValue;
                $val = preg_replace('~\x{00a0}~sui', ' ', $val);
                trim($val);
                array_push($rowdata, $val);
            }
            $data = array_combine($headerArray, $rowdata);
            $data['record id'] = $recordId;
            $allData[] = $data;
            //print 'rows:'.count($rowdata)."\n";
        }
        
        return $this->transformKeys($allData);
    }

    public function ParseCiTable($page)
    {
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;

        //setup xpath
        $xpath = new DOMXpath($doc);
        //get table by its ID
        $table = $doc->getElementById($this->tableId);
    /*
        $xquery = ".//tr[@canview='true']";
        $rows = $xpath->query($xquery, $table);*/
        $aRow = $xpath->query(".//td[@class='icr']/a[@data-original-title='View']", $table);
        $row = $aRow->item(0);
        //$val = $row->firstChild;
        $url = $row->getAttribute('href');

        $page = $this->GetTable('https://'.$this->host.'/db/'.$url);

        return $this->ParseCIPage($page);
    }

    public function ParseCIPage($page)
    {
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $doc->preserveWhiteSpace = false;

        /*$resource = fopen('qb-ci-'.$this->tableId.'.html', 'w');
        fwrite($resource, $page);
        fclose($resource);*/

        //setup xpath
        $xpath = new DOMXpath($doc);
        //get table by its ID
        $table = $doc->getElementById('sect_s2');

        $xquery = ".//tr[@class='formRow ']";
        $rows = $xpath->query($xquery);

        //$Rows = array();
        $allData = array();

        foreach ($rows as $row) {
            if (false === $row->hasChildNodes()) {
                continue;
            }

                // headers will have class='label'
                // data will have class='cell'
                $children = $row->childNodes;

            $key = '';
            $value = '';

            foreach ($children as $node) {
                if (false === $node->hasAttributes()) {
                    continue;
                }

                $classes = explode(' ', $node->getAttribute('class'));

                if (in_array('label', $classes)) {
                    $key = $node->nodeValue;
                    $key = preg_replace('~\x{00a0}~sui', ' ', $key);
                    trim($key);
                } elseif (in_array('cell', $classes)) {
                    $value = $node->nodeValue;
                    $value = preg_replace('~\x{00a0}~sui', ' ', $value);
                    trim($value);
                }
            }

            $allData[$key] = $value;
        }

        return $this->transformKeys($allData);
    }

    public function ParseCSV($file)
    {
        $separator = ',';
        $resource = fopen('qb-'.urlencode($this->tableId).'.csv', 'w');
        fwrite($resource, $file);
        fclose($resource);

        $data = array();
        $rowcount = 0;
        if (($handle = fopen('qb-'.urlencode($this->tableId).'.csv', "r")) !== false) {
            $max_line_length = defined('MAX_LINE_LENGTH') ? MAX_LINE_LENGTH : 0;
            $header = fgetcsv($handle, $max_line_length);
            $header_colcount = count($header);
            while (($row = fgetcsv($handle, $max_line_length)) !== false) {
                $row_colcount = count($row);
                if ($row_colcount == $header_colcount) {
                    $entry = array_combine($header, $row);
                    $data[] = $entry;
                } else {
                    error_log("csvreader: Invalid number of columns at line ".($rowcount + 2)." (row ".($rowcount + 1)."). Expected=$header_colcount Got=$row_colcount");

                    return;
                }
                $rowcount++;
            }
        //echo "Totally $rowcount rows found\n";
        fclose($handle);
        } else {
            error_log("csvreader: Could not read CSV \"$csvfile\"");

            return;
        }

        return $data;
    }

    public function RetrievePassword()
    {
        echo "RetrievePassword\n";

        $database = 'schedule';

        $dsn = 'mysql:host='.$this->dbhost.';dbname='.$database;
        $options = array( \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        $dbcon = new \PDO($dsn, $this->dbuser, $this->dbpass, $options);

        $SQL = "SELECT `idp`, `Pass` FROM `p` ORDER BY `p`.`Date`  DESC Limit 1";

        $sth = $dbcon->prepare($SQL);
        $sth->execute();

        $password = $sth->fetch(\PDO::FETCH_NUM);

        return $password;
    }

    public function RetrieveNextPassword($id)
    {
        echo "RetrieveNextPassword\n";

        $database = 'schedule';

        $dsn = 'mysql:host='.$this->dbhost.';dbname='.$database;
        $options = array( \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

        $dbcon = new \PDO($dsn, $this->dbuser, $this->dbpass, $options);

        // increment $id by 1 to get the next password
        $id += 1;

        // only 12 rows, need to reset when we overflow
        if ($id == 13) {
            $id = 1;
        }

        $SQL = "UPDATE `p` SET `Date` = CURDATE() WHERE `idp` = $id";
        $rows = $dbcon->exec($SQL);

        $result = ($rows > 0 ? true : false);

        return $result;
    }
    
    protected function transformKeys(array $list)
    {
        foreach ( $list AS $key => $value) {
            if (is_array($value)) {
                $list[$key] = $this->transformKeys($value);
            } else {
                $newKey = str_replace(array("\n", '/', ':'), ' ', $key);
                $newKey = strtolower($newKey);
                $newKey = str_replace("-", '', $newKey);
                $newKey = preg_replace('~(\w)\s+(\w)~', '$1_$2', $newKey);
                
                $list[$newKey] = $list[$key];
                if ( $newKey !== $key) {
                    unset($list[$key]);
                }
            }
        }
        
        return $list;
    }
}
