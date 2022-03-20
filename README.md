[TOC]

# PHP本地开发环境Docker-测试版


## Docker Compose介绍

Compose 是一个工具，定义和运行复杂Docker应用。使用Compose，你定义多容器应用在当个文件中，然后将你的所有应用联系在一起，通过单一命令就可以完成运行这么多容器应用的事情。




## 快速安装

> 3个版本的php会有大量的编译过程，已全部推送至阿里镜像仓库。下面2种安装方式选一即可

### 远程镜像安装(节约大量时间)

版本|远程地址
:-:|:-:
php5.6|registry.cn-shanghai.aliyuncs.com/ibaotu/php
php7.1|registry.cn-shanghai.aliyuncs.com/ibaotu/php7.1
php7.2|registry.cn-shanghai.aliyuncs.com/ibaotu/php7.2
php8.1.4|registry.cn-shanghai.aliyuncs.com/ibaotu/php8.1.4

1. [下载发布文件](https://github.com/zhangjunjie6b/phpdocker/releases)
2. 启动 docker-compose
> cd 到docker-compose.yml 同级目录
> 执行 ./docker-run.sh
3.  访问 http://127.0.0.1/ 查看是否正常启动


### 源码编译

2. git拉取docker-compose
> git clone git@github.com:zhangjunjie6b/phpdocker.git

3. 启动 docker-compose
> cd 到docker-compose.yml 同级目录
> 执行 ./docker-run.sh

4. 访问 http://127.0.0.1/ 查看是否正常启动

5. 根据项目需求配置相应项目（见技术群内项目包）


## 支持操作系统

操作系统|是否支持
:-:|:-:
win10 专业版|Y
MAC|Y
Linux|Y

[win10 环境安装][5]

## 目录结构
```
├── README.md  
├── docker-compose.yml //compose文件
├── mysql 
│   ├── Dockerfile
│   ├── conf
│   │   └── mysql.cnf
│   └── data    //数据库文件映射
├── nginx
│   ├── Dockerfile
│   ├── conf.d  //默认会读取此文件 *.conf
│   │   ├── default.conf
│   │   └── test.conf //127.0.0.1 测试配置
│   └── log
│       ├── access.log //访问日志
│       └── error.log  //错误日志
├── php
│   ├── Dockerfile
|   └── php-fpm.d //php-fpm 配置文件
│   └── conf
│       ├── php-fpm.conf 
│       └── php.ini
├── redis
│   ├── Dockerfile
│   ├── data    //redis持久化文件存储映射
│   └── redis-6379.conf 
└── www //git 忽略下面所有文件
|
└── www_test //测试项目文件
```
## 镜像介绍

### mysql

> 版本 mysql:5.6
> [docker 基础镜像][1]

### nginx
> 本地 1.13.12
> [nginx 基础镜像][2]

### php
> 版本 5.6.35-fpm-jessie

> [PHP 基础镜像][3]

> 已安装扩展

PHP5.6
```
[PHP Modules]
Core
ctype
curl
date
dom
ereg
fileinfo
filter
ftp
gd
gmp
hash
iconv
json
libxml
mbstring
mcrypt
mysql
mysqli
mysqlnd
openssl
pcre
PDO
pdo_mysql
pdo_sqlite
Phar
posix
readline
redis
Reflection
scws
session
SimpleXML
soap
SPL
sqlite3
standard
swoole
tokenizer
xdebug
xml
xmlreader
xmlwriter
Zend OPcache
zlib

[Zend Modules]
Xdebug
Zend OPcache
```


PHP7.1


```
[PHP Modules]
Core
ctype
curl
date
dom
fileinfo
filter
ftp
gd
gmp
hash
iconv
imagick
json
libxml
mbstring
mcrypt
mysqli
mysqlnd
openssl
pcntl
pcre
PDO
pdo_mysql
pdo_sqlite
Phar
posix
readline
redis
Reflection
scws
session
SimpleXML
SPL
sqlite3
standard
swoole
tokenizer
xdebug
xml
xmlreader
xmlwriter
Zend OPcache
zlib

[Zend Modules]
Xdebug
Zend OPcache


swoole

swoole support => enabled
Version => 4.0.1
Author => tianfeng.han[email: mikan.tenny@gmail.com]
coroutine => enabled
epoll => enabled
eventfd => enabled
timerfd => enabled
signalfd => enabled
cpu affinity => enabled
spinlock => enabled
rwlock => enabled
async http/websocket client => enabled
openssl => enabled
Linux Native AIO => enabled
pcre => enabled
zlib => enabled
mutex_timedlock => enabled
pthread_barrier => enabled
futex => enabled

Directive => Local Value => Master Value
swoole.aio_thread_num => 2 => 2
swoole.display_errors => On => On
swoole.use_namespace => On => On
swoole.use_shortname => On => On
swoole.fast_serialize => Off => Off
swoole.unixsock_buffer_size => 8388608 => 8388608

```


PHP7.2

```
[PHP Modules]
bcmath
Core
ctype
curl
date
dom
fileinfo
filter
ftp
gd
grpc
hash
iconv
imagick
json
libxml
mbstring
mysqli
mysqlnd
openssl
pcre
PDO
pdo_mysql
pdo_sqlite
Phar
posix
readline
redis
Reflection
session
SimpleXML
sodium
SPL
sqlite3
standard
swoole
tokenizer
xml
xmlreader
xmlwriter
Zend OPcache
zip
zlib

[Zend Modules]
Zend OPcache
```

php8.1.4
```
[PHP Modules]
bcmath
Core
ctype
curl
date
dom
fileinfo
filter
ftp
gd
grpc
hash
iconv
imagick
json
libxml
mbstring
mysqli
mysqlnd
openssl
pcre
PDO
pdo_mysql
pdo_sqlite
Phar
posix
readline
redis
Reflection
session
SimpleXML
sodium
SPL
sqlite3
standard
tokenizer
xml
xmlreader
xmlwriter
Zend OPcache
zip
zlib

[Zend Modules]
Zend OPcache
```

### redis

> 版本3.2.11 注：线上redis版本2.8
> [redis 基础镜像][4]

#### 补充

> redis 持久化配置分快照和写日志 这边只介绍写日志的配置，公司用的阿里服务所以有兴趣的同学可以私下交流

##### AOF
AOF：每次redis操作会写出操作日志，AOF会重写这些命令
减少磁盘占用量，加速恢复速度

##### AOF 三种策略
命令|always|everysec|no
:-:|:-:|:-:|:-:
优点|不丢失数据|每秒一次fsync丢一秒|不用惯
缺点|IO开销较大，一般sata盘只有几百TPS|丢一秒数据|不可控

* always (写命令刷新的缓冲区然后到硬盘)
* everysec （每秒写到硬盘）
* no（交给操作系统）

##### AOF重写配置

配置|含义
:-:|:-:
auto-aof-rewrite-min-szie|AOF文件重新需要的尺寸
auto-aof-rewrite-percentage|AOF文件增长率

统计名|含义
:-:|:-:
aof_current_size|AOF当前尺寸（单位：字节）
aof_base_size|AOF上次启动和重写的尺寸（单位：字节）

```
appendonly yes
appendfilename "appendonly-${port}.aof"
**appendfsync** everysec
dir /bigdiskpath
no-appendfsync-on-rewrite yes
```

## 端口映射关系

服务名|宿主机|容器
:-:|:-:|:-:
nginx|80 443|80 433
mysql|3308|3306
redis|6378|6379


## 


## 日常更新这3部即可
> git pull
> docker-compose build
> docker-compose up

## 容器使用本机服务

1. 添加环境变量

```
export DOCKERHOST=$(ifconfig | grep -E "([0-9]{1,3}\.){3}[0-9]{1,3}" | grep -v 127.0.0.1 | awk '{ print $2 }' | cut -f2 -d: | head -n1) \

```

2. docker-compose.yml 配置相应的 环境变量 映射关系


# 注 

1. 如非 './docker-run.sh' 脚本启动,请屏蔽docker-compose.yml的环境变量映射关系






  [1]: https://dev.aliyun.com/detail.html?spm=5176.1972343.2.2.79825aaaV14Eu9&repoId=1239
  [2]: https://dev.aliyun.com/detail.html?spm=5176.1972343.2.45.79825aaaV14Eu9&repoId=1242
  [3]: https://dev.aliyun.com/detail.html?spm=5176.1972343.2.73.79825aaaV14Eu9&repoId=1250
  [4]: https://dev.aliyun.com/detail.html?spm=5176.1972343.2.112.79825aaaV14Eu9&repoId=1259
  [5]: https://github.com/526353781/phpdocker/blob/master/win10.md
