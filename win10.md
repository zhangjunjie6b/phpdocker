# win10 docker环境安装

1. 下载docker for win10 
        内网：FTP 172.16.11.3 技术部常用软脚下
        外网：[点击下载][1]
        
2. 获取阿里加速地址
    >[获取阿里专用加速地址][2]
    
3. 配置docker加速（注：重启后需要手动再设置一次）

    ![此处输入图片的描述][3]

4. git拉取docker-compose
    > 详细看compose安装介绍

4. 映射本地磁盘（注：docker-compose 在什么目录就需要映射什么目录）

     ![此处输入图片的描述][4]

    


  [1]: https://download.docker.com/win/stable/Docker%20for%20Windows%20Installer.exe
  [2]: https://cr.console.aliyun.com/?spm=5176.1971733.0.2.6c045aaavJIjPu&accounttraceid=8a3aed5f-98bb-4e0d-8ac3-0f35415295db#/accelerator
  [3]: http://pic.geekstool.com/markdown/0773437A1DAC122B4B7D2EC1C93F293D.jpg
  
  [4]: http://pic.geekstool.com/markdown/6C48C4DFEA57FF39E6370057F3945C9C.png