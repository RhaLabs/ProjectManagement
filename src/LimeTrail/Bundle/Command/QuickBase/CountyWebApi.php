<?php
namespace LimeTrail\Bundle\Command\QuickBase;

class CountyWebApi
{
    // The User-Agent string to send
  public $userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5";

    public function __construct()
    {
    }

    private function GetWebData($city, $state)
    {
        /*http://www.sba.gov/about-sba/sba_performance/sba_data_store/web_service_api/u_s_city_and_county_web_data_api*/
   // URL to login page
    $url = 'http://api.sba.gov/geodata/all_data_for_city_of/'.urlencode($city).'/'.urlencode($state).'.json';

        return file_get_contents($url);

    //returns
    /*
    [{"county_name":"Orleans",
    "description":null,
    "feat_class":"Populated Place",
    "feature_id":"11370",
    "fips_class":"C5",
    "fips_county_cd":"71",
    "full_county_name":"Orleans Parish",
    "link_title":null,
    "url":"http:\/\/www.cityofno.com\/",
    "name":"New Orleans",
    "primary_latitude":"29.95",
    "primary_longitude":"-90.07",
    "state_abbreviation":"LA",
    "state_name":"Louisiana"}]
    */
    }

    public function GetCountyByCityState($city, $state)
    {
        $obj = $this->mjson_decode($this->GetWebData($city, $state));
    //var_dump($obj);
    if ($obj) {
        return $obj[0]->full_county_name;
    } else {
        return;
    }
    }
    public function mjson_decode($json)
    {
        return json_decode($this->removeTrailingCommas(utf8_encode($json)));
    }

    public function removeTrailingCommas($json)
    {
        $json = preg_replace('/,\s*([\]}])/m', '$1', $json);

        return $json;
    }
    public function json_last_error_msg()
    {
        static $errors = array(
            JSON_ERROR_NONE             => null,
            JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
            JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded',
        );
        $error = json_last_error();

        return array_key_exists($error, $errors) ? $errors[$error] : "Unknown error ({$error})";
    }
}
