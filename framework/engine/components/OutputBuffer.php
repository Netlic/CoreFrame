<?php
namespace framework\engine\components;

class OutputBuffer extends Component{
    const OUTPUT_CLEANABLE = 16;
    const OUTPUT_FLUSHABLE = 32;
    const OUTPUT_REMOVABLE = 64;
    const OUTPUT_STDFLAGS = 112;
    
    private $cleaned = false;
    private $flag = self::OUTPUT_STDFLAGS;
    private $flushed = false;
    private $ob_started = false;
    
    public function start(callable $callback = null, int $chunk = 0, int $flag = self::OUTPUT_STDFLAGS){
        $this->ob_started = true;
        if($this->flag != $flag){
            $this->flag = $flag;    
        }
        return ob_start($callback, $chunk, $flag);
    }
    
    public function clean($destroyBuffer = false){
        if($this->ob_started){
            $this->cleaned = true;
            if($destroyBuffer){
                ob_end_clean();
                $this->ob_started = false;
                return true;
            }
            ob_clean();
            return true;
        }
        return false;
    }
    
    public function flush($destroyBuffer = false){
        $this->flushed = true;
        if($destroyBuffer){
            ob_end_flush();
            $this->ob_started = false;
            return true;
        }
        ob_flush();
        return true;
    }
    
    public function getContents(){
        if($this->ob_started){
            return ob_get_contents();
        }
        return false;
    }
    
    public function getFlush(){
        if($this->ob_started){
            return ob_get_flush();
        }
        return false;
    }
    
    public function getClean(){
        if($this->ob_started){
            return ob_get_clean();
        }
        return false;
    }
}
