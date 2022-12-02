<?php
require_once dirname(__FILE__) . '/../public/init.php';

if($argc < 2)
{
    echo "Wecome use phal command tool v0.0.1 \n\n";
    FormatOutput::setContent("Example:")->color(170,137,44)->outPut();
    echo "  {$argv[0]} -a User/Reg\n\n";
    FormatOutput::setContent("Usage:")->color(170,137,44)->outPut();
    echo "  Command [options] [arguments] \n";
    FormatOutput::setContent("  --a")->color(118,136,45)->outPut();
    echo "          创建一个API层文件 \n";
    FormatOutput::setContent("  --d")->color(118,136,45)->outPut();
    echo "          创建一个Domain层文件 \n";
    FormatOutput::setContent("  --m")->color(118,136,45)->outPut();
    echo "          创建一个Model层文件 \n";
}

$params = getopt('',['a:','d:','m:','p:']);

$project = isset($params['p'])?$params['p']:'app';

$baseDir = API_ROOT."/src/".$project;

if(empty($params))
{
    FormatOutput::setContent('options error')->backgroundColor(255)->color()->outPut("\n");
}

if(isset($params['a']))
{
    createApi($params['a']);
}

if(isset($params['d']))
{
    createDomain($params['d']);
}

if(isset($params['m']))
{
    createModel($params['m']);
}

function createApi($pathName)
{
    global $project,$baseDir;
    $project = ucfirst($project);
    $pathInfo = pathinfo($pathName);
    if("." != $pathInfo['dirname'])
        $namespace = "\\".$pathInfo['dirname'];
    else
        $namespace = "";
    $temp = <<<apiTemp
<?php

namespace {$project}\Api{$namespace};

use PhalApi\Api;

class {$pathInfo['filename']} extends Api {
    public function getRules() {
        return array();
    }
}
apiTemp;
    $dir = $baseDir."/Api/".$pathInfo['dirname']."/";
    $filename = $pathInfo['filename'].".php";
    $file = $dir.$filename;
    if(!is_file($file))
    {
        if(!is_dir($dir))
        {
            if(!mkdir($dir,0755))
            {
                FormatOutput::setContent('Dir create fail!')->color(255)->outPut("\n");
            }
        }
        if(touch($file))
        {
            if(file_put_contents($file,$temp))
            {
                FormatOutput::setContent('Api file created successfully.')->color(118,136,45)->outPut("\n");
            }else{
                FormatOutput::setContent('File create fail!')->color(255)->outPut("\n");
            }
        }else{
            FormatOutput::setContent('File create fail!')->color(255)->outPut("\n");
        }
    }else{
        FormatOutput::setContent('File already created!')->color(255)->outPut("\n");
    }
}

function createDomain($pathName)
{
    global $project,$baseDir;
    $project = ucfirst($project);
    $pathInfo = pathinfo($pathName);
    if("." != $pathInfo['dirname'])
        $namespace = "\\".$pathInfo['dirname'];
    else
        $namespace = "";
    $temp = <<<apiTemp
<?php

namespace {$project}\Domain{$namespace};

class {$pathInfo['filename']} {
    
}
apiTemp;
    $dir = $baseDir."/Domain/".$pathInfo['dirname']."/";
    $filename = $pathInfo['filename'].".php";
    $file = $dir.$filename;
    if(!is_file($file))
    {
        if(!is_dir($dir))
        {
            if(!mkdir($dir,0755))
            {
                FormatOutput::setContent('Dir create fail!')->color(255)->outPut("\n");
            }
        }
        if(touch($file))
        {
            if(file_put_contents($file,$temp))
            {
                FormatOutput::setContent('Api file created successfully.')->color(118,136,45)->outPut("\n");
            }else{
                FormatOutput::setContent('File create fail!')->color(255)->outPut("\n");
            }
        }else{
            FormatOutput::setContent('File create fail!')->color(255)->outPut("\n");
        }
    }else{
        FormatOutput::setContent('File already created!')->color(255)->outPut("\n");
    }
}

function createModel($pathName)
{
    global $project,$baseDir;
    $project = ucfirst($project);
    $pathInfo = pathinfo($pathName);
    if("." != $pathInfo['dirname'])
        $namespace = "\\".$pathInfo['dirname'];
    else
        $namespace = "";
    $temp = <<<apiTemp
<?php

namespace {$project}\Model{$namespace};

use PhalApi\Model\DataModel;

class {$pathInfo['filename']} extends DataModel {

    protected function getTableName(\$id) {
        return '';
    }
}
apiTemp;
    $dir = $baseDir."/Model/".$pathInfo['dirname']."/";
    $filename = $pathInfo['filename'].".php";
    $file = $dir.$filename;
    if(!is_file($file))
    {
        if(!is_dir($dir))
        {
            if(!mkdir($dir,0755))
            {
                FormatOutput::setContent('Dir create fail!')->color(255)->outPut("\n");
            }
        }
        if(touch($file))
        {
            if(file_put_contents($file,$temp))
            {
                FormatOutput::setContent('Api file created successfully.')->color(118,136,45)->outPut("\n");
            }else{
                FormatOutput::setContent('File create fail!')->color(255)->outPut("\n");
            }
        }else{
            FormatOutput::setContent('File create fail!')->color(255)->outPut("\n");
        }
    }else{
        FormatOutput::setContent('File already created!')->color(255)->outPut("\n");
    }
}

/**
 * 命令行输出字符格式化类
 * Class FormatOutput
 * @package MPQueue\OutPut
 */
class FormatOutput
{
    private $label = '';
    private $content;
    private $outFile = null;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * 设置输出到文件/直接输出
     * @param null $outFile 文件地址/null(直接输出)
     */
    public function setOutFile($outFile = null){
        $this->outFile = $outFile;
        return $this;
    }

    /**
     * 设置粗体/增强
     */
    public function strong()
    {
        $this->label.= '1;';
        return $this;
    }

    /**
     * 设置斜体(未广泛支持。有时视为反相显示。)
     */
    public function italic()
    {
        $this->label.= '3;';
        return $this;
    }

    /**
     * 上划线
     */
    public function overline(){
        $this->label.= '53;';
        return $this;
    }

    /**
     * 中划线（未广泛支持）
     */
    public function lineThrough()
    {
        $this->label.= '9;';
        return $this;
    }

    /**
     * 下划线
     */
    public function underline()
    {
        $this->label.= '4;';
        return $this;
    }

    /**
     * 缓慢闪烁（低于每分钟150次）
     */
    public function slowBlink()
    {
        $this->label.= '5;';
        return $this;
    }

    /**
     * 快速闪烁（未广泛支持）
     */
    public function fastBlink()
    {
        $this->label.= '6;';
        return $this;
    }

    /**
     * 设置字体颜色/前景色(rgb色值 默认为白色)
     * @param int $r 红 0-255
     * @param int $g 绿 0-255
     * @param int $b 蓝 0-255
     */
    public function color(int $r = 255, int $g = 255, int $b = 255)
    {
        $this->label.= "38;2;$r;$g;$b;";
        return $this;
    }

    /**
     * 设置背景景色(rgb色值 默认为黑色)
     * @param int $r 红 0-255
     * @param int $g 绿 0-255
     * @param int $b 蓝 0-255
     */
    public function backgroundColor(int $r = 0, int $g = 0, int $b = 0)
    {
        $this->label.= "48;2;$r;$g;$b;";
        return $this;

    }

    /**
     * 输出内容
     */
    public function outPut($n=""){
        if($this->outFile){
            file_put_contents($this->outFile,$this->getFormatContent(),FILE_APPEND | LOCK_EX);
        }else{
            echo $this->getFormatContent().$n;
        }
    }

    /**
     * 获取格式化后的输出内容
     * @return string
     */
    public function getFormatContent(): string
    {
        $this->label = rtrim($this->label,';');
        return "\e[{$this->label}m{$this->content}\e[0m";
    }

    /**
     * 静态调用快速设置内容
     * @param string $content
     * @return FormatOutput
     */
    public static function setContent(string $content)
    {
        return new self($content);
    }
}
