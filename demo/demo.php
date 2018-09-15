<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/6/25
 * Time: 上午11:21
 */

ini_set('date.timezone', 'Asia/Shanghai');

class A
{
    public        $a;
    public static $b;

    function add ($a)
    {
        $this->a = $a;
        return $this;
    }

    function setA ()
    {
        $this->a = strtolower($this->a);
        return $this;
    }

    function getA ()
    {
        return $this->a;
    }

}

/**
 * 多进程任务
 * Class Fork
 */
class Fork
{
    public function __construct ()
    {
        if (!function_exists('pcntl_fork')) {
            die("pcntl_fork not existing");
        }
        $arr  = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $arrs = array_chunk($arr, 2);

        $task            = 0; //任务id
        $taskNum         = count($arrs);//任务总数
        $processNumLimit = 2; //子进程总量限制

        //创建管道
        $pipePath = "/tmp/test.pipe";
        if( !file_exists( $pipePath ) ){
            if( !posix_mkfifo( $pipePath, 0666 ) ){
                exit('make pipe false!' . PHP_EOL);
            }
        }

        $nums = 0 ;
        while (true) {
            $processid = pcntl_fork();
            if ($processid == -1) {
                echo "create process error! \n";
                exit(1);
            } elseif ($processid) {
                $task++;
                $currentProcessid = posix_getpid(); //当前进程的Id
                $parentProcessid = posix_getppid(); // 父级进程的ID
                $phpProcessid = getmypid(); //当前php进程的id
                echo "父-task:",$task,"\n";

                $file = fopen( $pipePath, 'r' );
                stream_set_blocking( $file, False );  //设置成读取非阻塞
                $is = (int)fread( $file, 20 );
                $nums += $is;
                echo $nums;
                fclose($file);

                //控制进程数
                if($task >= $processNumLimit) {
                    echo "wait chl start！\n";
                    $exitid = pcntl_wait($status); //等待退出
                    echo "wait chl end！extid:",$exitid,"\tstatus:",$status,"\n";
                }

                //任务总量控制
                if($task >= $taskNum) {
                    echo "taskNum enough！$nums \n";
                    unlink($pipePath);
                    break;
                }
            }else {
                //模拟不同任务的不同执行时长
                $sleep = rand(1, 5);

                $currentProcessid = posix_getpid(); //当前进程的Id
                $parentProcessid = posix_getppid(); // 父级进程的ID
                $phpProcessid = getmypid(); //当前php进程的id
//                echo "task:",$task,"\tprocessid:",$processid,"\tcurrentProcessid:",$currentProcessid,"\tparentProcessid:",$parentProcessid,"\tphpProcessid:",$phpProcessid,"\tsleep:",$sleep,"\tbegin!\n";

                sleep($sleep);

                $i = 0 ;
                foreach ($arrs[$task] as $v){
                    $i++;
                }
                $file = fopen( $pipePath, 'w' );
                fwrite( $file, $i);
                fclose($file);

                echo "task:",$task."\n";

                exit(0); //子进程执行完后退出，防止进入循环创建子进程
            }
        }

    }

}

/**
 * 单列模式 操作Redis
 * Class Cache
 */
class Cache{
    static private $_instance;
    static private $_connectRedis;
    private function __construct()
    {
    }
    static public function getInstance(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function redis(){
        if (!self::$_connectRedis instanceof self){
            $redis = new Redis();
            $redis->connect('127.0.0.1');
            $redis->select(2);
            self::$_connectRedis = $redis;
        }
        return self::$_connectRedis;
    }
    public function setA($key,$val){
        self::$_connectRedis->set($key,$val);
    }

}

//$a = new A();

//echo $a->add('adADf')->setA()->getA();


//$f = new Fork();
//$i = 10;
//require __DIR__.'/../vendor/autoload.php';
//Resque::setBackend('127.0.0.1:6379',1);
//
//$args = array(
//    'time' => time(),
//    'array' => array(
//        'test' => 'test',
//    ),
//);
//$jobId = Resque::enqueue('default','PHP_Job', $args, true);

$cache = Cache::getInstance()->redis();

//$cache->set('aa','ds',1000);
echo $cache->get('aa');