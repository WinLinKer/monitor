<?php
    class Ngx_luaAction extends CommonAction
    {   
        
        public function log()
        {   
            
            if(isset($_POST["sitename"]))
            {
                $sitename = $_POST['sitename'];
                $conf_path = C("NLMD_LOG");
                $file_name= $conf_path."/".$sitename."_sec.log";
                $filecode = $this->file_read($file_name);
                /*
                $xx = system("sed -n '/2013:18:39:16/,/2013:19:21:50/p' /Users/suzie/Config/openresty/logs/access.log");
                echo $xx;
                */
                $this->assign("sitename",$sitename);
                $this->assign("filecode",$filecode);
                
            }
            $this->display('log'); 
        }


        public function global_rule()
        {
            $this->show("global");
        }

       public function get()
       {
           $this->show("get");
       }
       public function post()
       {
           $this->show("post");
       }
       public function useragent()
       {
           $this->show("user-agent");
       }
       public function whitelist()
       {
           $this->show("whitelist");
       }
       public function ipwhitelist()
       {
           $this->show("ipwhitelist");
       }
       public function ipblacklist()
       {
           $this->show("ipblacklist");
       }
       /**
        *   展示页面
        *   @param 
        *   @return  
        */
       public function show($conf_name)
       {
           $conf_path = C("NLMD_CONF");
           $conf = $conf_path."/".$conf_name;
           $filecode = $this->file_read($conf);
           $this->assign("Rule",$conf_name);
           $this->assign("filecode",$filecode);
           $this->display('show'); 
       }

        /**
        *   读文件
        *   @param string $file_name 文件名
        *   @return string $filecode 文件内容
        */
        private function file_read($file_name)
        {
            $handle = @fopen($file_name,"rb");
            $filecode = @fread($handle,@filesize($file_name));
            fclose($handle);
            return $filecode;
        }
        /**
        *   写文件
        */
        public function file_edit()
        {
            $conf_name = $_POST['rule_conf'];
            $conf_content = $_POST['rule_content'];
            $conf_path = C("NLMD_CONF");
            $file_name= $conf_path."/".$conf_name;
            //echo $file_name;
            $handle = @fopen($file_name,"wb");
            $result = @fwrite($handle,$conf_content);
            fclose($handle);
            if($result)
            {    
                $msg='修改成功! ';
                echo "{";
                echo "\"msg\":\"".$msg."\"";
                echo "}";
            }
            else{
                   # code...
                $msg='修改失败! ';
                echo "{";
                echo "\"msg\":\"".$msg."\"";
                echo "}";
            }   
        } 
}
