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

$a = new A();
$redis = new Redis();
echo phpinfo();

//echo $a->add('adADf')->setA()->getA();


//$f = new Fork();
$i = 10;
echo "初始: ".memory_get_usage()."B\n";
echo $allPage = ceil(10/3);
echo "使用: ".memory_get_usage()."B\n";
$allPage = null;
echo '123';
echo "使用: ".memory_get_usage()."B\n";

