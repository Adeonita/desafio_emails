<?php

  class Reader {

    private $file = '';

    public function file_get_contents_chunked($file,$chunk_size,$callback){
        try{
            $handle = fopen($file, "r");
            $i = 0;
            while (!feof($handle)){
                call_user_func_array($callback,array(fread($handle,$chunk_size),&$handle,$i));
                $i++; 
              }
            fclose($handle);
        }
        catch(Exception $e){
          trigger_error("file_get_contents_chunked::" . $e->getMessage(),E_USER_NOTICE);
          return false;
        }
      return true;
    }

    public function read($caminhoArquivo){
      $success = $this->file_get_contents_chunked($caminhoArquivo,4096,function($chunk,&$handle,$iteration) {
        $this->file .= str_replace(['\'', "\r"], '', $chunk);
      });
      $this->file = explode("\n", $this->file); 
      return $this->file;
    }
         
  }
 ?>