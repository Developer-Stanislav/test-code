<?php

class FileManager
{

    protected static $_instance;
    protected $scan;
    protected $render;
    private $path = '/index.php';
    private $sort = 'name';
    private $order_by = 'asc';
    private $extensions = array('png','jpg','ico');


    private function __construct(){ }
    private function __clone(){ }
    private function __wakeup(){ }
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
    public function sort($sort = '', $order_by = 'asc')
    {


        $sort_values = array('type', 'size');
        $this->sort = in_array($sort, $sort_values) ? $sort : 'name';
        $this->order_by = ($order_by == 'desc')?'desc':'asc';
        $sort_dirs = array();
        $sort_order = array();
        foreach ($this->scan as $key => $value) {
            $sort_dirs[$key] = $value['sort'];
            $sort_order[$key] = $value[$this->sort];
        }
        array_multisort($sort_dirs, SORT_ASC, $sort_order, ($this->order_by == 'desc') ? SORT_DESC : SORT_ASC, $this->scan);
        return self::$_instance;

    }
    public function scan($path)
    {
        $this->path = str_replace('/', '-', $path);

        $scan_dir = DIR_IMAGE;
        $up_path = false;

        if ($path) {
            $scan_dir .= $path . '/';
            $up_path = str_replace('/', '-', substr($path, 0, strrpos($path, '/')));
        }

        $this->scan = array();
        if ($up_path !==  false) {
            $this->scan[] = array(
                'name' => '..',
                'path' => $up_path?$up_path:'',
                'type' => '',
                'size' => '',
                'sort' => '0',
            );
        }


        if (is_dir($scan_dir)) {
            $scan_dir_array = scandir($scan_dir);
            foreach ($scan_dir_array as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }
                $info = pathinfo($scan_dir . $item);
                if (is_dir($scan_dir . $item)) {
                    $this->scan[] = array(
                        'name' => $info['basename'],
                        'path' => $path ? str_replace('/', '-', $path) . '-' . $info['basename'] : $info['basename'],
                        'type' => '',
                        'size' => '',
                        'sort' => '1',
                    );
                } elseif (is_file($scan_dir . $item)) {


                    $this->scan[] = array(
                        'name' => $info['basename'],
                        'path' => '',
                        'type' => $info['extension'],
                        'size' => filesize($scan_dir . $item),
                        'sort' => '2',
                    );
                }
            }
        }else{
            $this->scan[] = array(
                'name' => 'Error. Failed to open dir: '.str_replace(DIR_IMAGE,'/',$scan_dir).'. No such directory ',
                'path' => '',
                'type' => 'error',
                'size' => '',
                'sort' => '3',
            );
        }

        return self::$_instance;


    }


    public function __toString(){
        $data = array();
        $data['folder'] = array();
        foreach ($this->scan as $item){
            $url = 'index.php?';
            if($item['path']){
                $url .= 'path='.$item['path']."&";
            }
            if($this->sort != 'name'){
                $url .= 'sort='.$this->sort."&";
            }
            if($this->order_by != 'asc'){
                $url .= 'order='.$this->order_by.'&';
            }
            $url = htmlentities(substr($url,0,-1));
            $data['folder'][] = array(
                'href' => $url,
                'name' => $item['name'],
                'size' => $item['size'],
                'type' => $item['type'],
                'path' => $item['path'],
            );


        }

        $data['sort'] = $this->sort;
        $data['order_by'] = $this->order_by;
        $url = 'index.php?';
        if($this->path){
            $url .= 'path='.$this->path."&";
        }
        if ($this->order_by == 'asc') {
            $url .= 'order=desc&';
        }
        $data['sort_name'] = htmlentities($url.'sort=name');
        $data['sort_size'] = htmlentities($url.'sort=size');
        $data['sort_type'] = htmlentities($url.'sort=type');

        return render('file_manager', $data);
    }
}