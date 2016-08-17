<?php
/**
 * @Description: Создано в России
 * @User: aleksey.nikulin
 * @Date: 27.06.2016
 * @Time: 13:17
 * @Email: masterweb@e1.ru
 */

namespace boxberryApi {

    use BoxberryApi\Json\Json;
    use BoxberryApi\Soap\Soap;

    class boxberry
    {
        /**
         * @var string
         */
        public $method='';

        /**
         * @var array
         */
        public $args=[];

        /**
         * @var string
         */
        public $type = 'soap';

        const NotIsArray = "Argument not is array";

        public function __construct()
        {
        }

        /**
         * @param array $attr
         */
        private function hasAttr($attr=[]){
            if(!is_array($attr)){
                throw new \InvalidArgumentException(self::NotIsArray);
            }
        }

        /**
         * @param array $attr
         * @return array
         */
        public function setMethod($attr=[]){
            if(!empty($attr['method'])){
                $this->method = $attr['method'];
                unset($attr['method']);
            }
            return $attr;
        }

        /**
         * @param array $attr
         */
        public function setAttr($attr=[]){
            $this->hasAttr($attr);
            $this->args = $this->setMethod($attr);
        }

        /**
         * @param array $attr
         * @return array|mixed
         */
        public function getData($attr=[]){
            $this->setAttr((!empty($attr))? $attr : $this->args);
            return $this->Request();
        }

        /**
         * @return array|mixed
         */
        private function Request(){
            if($this->type == 'soap'){
                return $this->requestSoap();
            } else {
                return $this->requestJson();
            }
        }

        private function requestSoap(){
            include(BOXBERRY_DIR."/driver/soap.php");
            $driver = new Soap($this->method,$this->args);
            $data = $driver->Request();
            if(count($driver->error)){
                return ["err" => $driver->error];
            }
            return $data;
        }

        private function requestJson(){
            include(BOXBERRY_DIR."/driver/json.php");
            $driver = new Json($this->method,$this->args);
            $data = $driver->Request();
            if(count($driver->error)){
                return ["err" => $driver->error];
            }
            return $data;
        }
    }
}