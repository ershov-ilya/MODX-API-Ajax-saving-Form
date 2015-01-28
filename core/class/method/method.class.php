<?php
/**
 * Created by PhpStorm.
 * User: ershov-ilya
 * Website: ershov.pw
 * GitHub : https://github.com/ershov-ilya
 * Date: 25.01.2015
 * Time: 12:52
 */
class Method {
    private $private_scope;
    public $scope;
    static $filter;

    function __construct($filter=array('METHOD','id')){
        Method::$filter = $filter;
        // Define method type
        if(isset($_SERVER['argc'])) define('METHOD', 'CONSOLE');//$this->private_name='CONSOLE';
        elseif(isset($_SERVER['REQUEST_METHOD']))  define('METHOD', $_SERVER['REQUEST_METHOD']); //$this->private_name=$_SERVER['REQUEST_METHOD'];
        else{
            define('METHOD', 'UNKNOWN');
        }

        // Combine parameters
        $this->private_scope = array();
        if(METHOD=='CONSOLE') {
            //$this->private_scope = array_merge($this->private_scope, $_SERVER['argv']);
            require(API_CORE_PATH.'/class/method/getoptions.php');
            $this->private_scope = array_merge($this->private_scope, getOptions());
        }
        else{
            $this->private_scope = array_merge($this->private_scope, $_REQUEST);
            $this->private_scope = array_merge($this->private_scope, $this->parseRequestHeaders());
        }

        $this->private_scope['METHOD']=METHOD;
        $this->scope = $this->sanitize($this->filtrateScope());
        return $this->private_scope;
    }

    function getRaw(){
        return $this->private_scope;
    }

    function parseRequestHeaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    function sanitize($arr, $filter=array()){
        $out=array();
        foreach($arr as $key => $val) {
            if(isset($filter[$key])){
                $out[$key] = filter_var($val, $filter[$key]);
                continue;
            }
            switch ($key) {
                case 'METHOD':
                    $out[$key] = filter_var($val, FILTER_SANITIZE_STRING);
                    break;
                case 'id':
                    $out[$key] = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
                    break;
                case 'email':
                    $out[$key] = filter_var($val, FILTER_SANITIZE_EMAIL);
                    break;
                default:
                    $out[$key] = $val;
            }
        }
        return $out;
    }

    function filtrate($arr, $filter=NULL){
        if($filter==NULL) $filter=Method::$filter;
//        if(DEBUG) {
//            if (is_array($filter)) print "Filter type Array\n";
//            if (is_string($filter)) print "Filter type String\n";
//        }
        if (is_string($filter)){
            $filter=explode(',',$filter);
        }
        print_r($filter);

        $res=array();
        foreach($filter as $el){
            $el_cropspace=preg_replace('/ /','',$el);
            if(isset($arr[$el_cropspace])) $res[$el_cropspace]=$arr[$el_cropspace]; // Вырезаем пробелы из имён параметров
            if(isset($arr[$el])) $res[$el]=$arr[$el];
        }
        return $res;
    }

    function filtrateScope($filter=NULL){
        return $this->filtrate($this->private_scope,$filter);
    }

    function test(){
        if(DEBUG)
        {
            print "Test function: ";
            print "Method: ".METHOD."\n";
            print "Scope: \n";
            print_r($this->scope);

            $this->scope['id']='12423421/**/3432@//23144';
            $this->scope['ordernum']='12423421/**/3432@//23144';

            print 'DEBUG data:'."\n";
            print_r($this->scope);

            print '$filterRes:'."\n";
//            $filterRes=$this->filtrate($this->scope, array('id', 'email', 'ordernum', 'orderSum'));
            $filterRes=$this->filtrate($this->scope);
            print_r($filterRes);

            print '$sanitizeRes:'."\n";
            $sanitizeRes=$this->sanitize($filterRes, array('ordernum'=>FILTER_SANITIZE_NUMBER_INT));
            print_r($sanitizeRes);

        }
    }
}