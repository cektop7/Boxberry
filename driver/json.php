<?
/**
 * @Description: Создано в России 
 * @User: aleksey.nikulin
 * @Date: 16.08.2016
 * @Time: 14:34
 * @Email: masterweb@e1.ru
 */

namespace BoxberryApi\Json;

class Json{

    /**
     * @var array
     */
    public $args = [];

    /**
     * @var array
     */
    public $error = [];

    const ResNotData = "Response not data";

    /**
     * @param string $method
     * @param array $args
     */
    function __construct($method = '', $args = [])
    {
        $args['method'] = $method;
        $this->args = $args;
    }

    /**
     * @param string $data
     * @return mixed
     */
    function toArray($data='')
    {
        return json_decode($data, 1);
    }

    /**
     * @return mixed
     */
    function Request()
    {
        try{
            $this->connect();

            if($data = \Requests::post(HOST.JSON_SERVICE,[],
                $this->args
            )){
                return $this->toArray($data->body);
            } else {
                $this->error[] = self::ResNotData;
            }
        } catch (\Exception $e){
            $this->error[] = $e->getMessage();
        }
    }

    function connect(){
        require_once(BOXBERRY_DIR.'/driver/Request/library/Requests.php');
        \Requests::register_autoloader();
    }
}