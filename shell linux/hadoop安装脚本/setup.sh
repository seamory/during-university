#!/bin/bash

runningDir="/opt"

# 安装开始
echo "----------------------------------------------------------------------------"
echo "hadoop install shell"
echo "----------------------------------------------------------------------------"

# 解包安装
size=0
tail -c $size  install_hadoop.bin > all.tar.gz
tar -zxvf all.tar.gz

# 配置安装目录
echo "running dir is" $runningDir, "Did you want to change it?(y/n)"
read chose
if [ "$chose" == 'y' ]
	then
		echo -n "Please input your running Dir:"
		read runningDir
		echo $runningDir
	else
		echo "continue."
fi
choes=""
echo "----------------------------------------------------------------------------"	

# 检测安装目录是否存在，如果存在则删除
if [ -d "$runningDir" ]
	then
		echo "Install path exist, deleting..."
		rm -rf $runningDir
		echo "Delete sucess"
fi
echo "----------------------------------------------------------------------------"

# 停止所有hadoop进程
for PID in $(jps | grep -v Jps | awk '{print $1}')
	do
		echo "Stoping "
		kill $PID
done
echo "All hadoop running progress had stopped"
echo "----------------------------------------------------------------------------"

# 生成ssh密钥
ssh-keygen -t rsa -P ''

# 生成ssh密钥到文件
touch /root/.ssh/authorized_keys
cat /root/.ssh/id_rsa.pub >> /root/.ssh/authorized_keys
echo "----------------------------------------------------------------------------"

# 配置本机hostname
echo "hostname is" hostname, "Did you want to change it?(y/n)"
read chose
if [ "$chose" == 'y' ]
	then
		echo -n "Please input your hostname:"
		read hn
		hostname $hn
	else
		echo "continue."
fi
chode=""
echo "----------------------------------------------------------------------------"	

# 添加本地ip列表到host地址中
ipLs=ifconfig | grep -w inet | awk '{print $2}' | awk -F ':' '{print $2}'

for ip in ipLs
	do 
		echo $ip"\t"$hn >> /etc/hosts
done
echo "----------------------------------------------------------------------------"

# 检查安装目录是否存在 如果不存在则创建
if [ ! -d "$runningDir" ]
        then
                mkdir -p "$runningDir"
				chmod 777 $runningDir
fi
echo "----------------------------------------------------------------------------"

# 检查hadoop安装文件包是否存在 

if [ "hadoop" != $(ls | grep -w 'hadoop' | grep -w 'tar.gz' | awk -F '-' '{print $1}') ]
        then
                echo -n "Hadoop安装文件包不存在,退出安装"
                read tmp
                exit
else
	# 解包安装文件
	tar -xvzf $(ls | grep -w 'hadoop' | grep -w 'tar.gz')
	# 配置HADOOP目录
	hadoopHome=$runningDir/$(ls | grep -w 'hadoop' | grep -v 'tar')
	# 移动到运行目录
	#mv $(ls | grep -w 'hadoop' | grep -v 'tar.gz') $runningDir/$(ls | grep -w 'hadoop' | grep -v 'tar')
	mv $(ls | grep -w 'hadoop' | grep -v 'tar.gz') $runningDir
fi
echo "----------------------------------------------------------------------------"

# 检查java安装文件包是否存在
if [ "jdk" != $(ls | grep -w 'jdk' | grep -w 'tar.gz' | awk -F '-' '{print $1}') ]
        then
                echo -n "java安装文件包不存在,退出安装"
                read tmp
                exit
else
	#解包安装文件
	tar -xvzf $(ls | grep -w 'jdk' | grep -w 'tar.gz')
	# 配置JAVA目录
	javaHome=$runningDir/$(ls | grep -w 'jdk' | grep -v 'tar')
	# 移动到运行目录
	#mv $(ls | grep -w 'jdk' | grep -v 'tar.gz') $runningDir/$(ls | grep -w 'jdk' | grep -v 'tar')
	mv $(ls | grep -w 'jdk' | grep -v 'tar.gz') $runningDir
fi
echo "----------------------------------------------------------------------------"

# 配置JAVA运行环境
echo "export JAVA_HOME=$javaHome/
export JRE_HOME=$javaHome/jre
export CLASSPATH=.:\$CLASSPATH:\$JAVA_HOME/lib:\$JRE_HOME/lib
export PATH=$PATH:\$JAVA_HOME/bin:\$JRE_HOME/bin" >> /etc/profile
echo "----------------------------------------------------------------------------"

# 配置HADOOP运行环境
echo "export HADOOP_HOME=$hadoopHome/
export PATH=$PATH:\$HADOOP_HOME/bin" >> /etc/profile
echo "----------------------------------------------------------------------------"

# 更新环境
source /etc/profile
echo "----------------------------------------------------------------------------"

# 配置HADOOP运行目录 
#mkdir  $hadoopHome/tmp  
mkdir  $hadoopHome/var  
mkdir  $hadoopHome/dfs  
mkdir  $hadoopHome/dfs/name  
mkdir  $hadoopHome/dfs/data
echo "----------------------------------------------------------------------------"

# 配置HADOOP运行设置
chmod -R 777 $runningDir

# 配置hadoop-env.sh
sed -i "s:\${JAVA_HOME}:$javaHome:g" $hadoopHome/etc/hadoop/hadoop-env.sh

# 配置core-site.xml
sed -i "/<configuration>/a\ \n\<property\>\n\<name\>hadoop.tmp.dir\<\/name\>\n\<value\>$hadoopHome/tmp\<\/value\>\n\<description\>Abase for other temporary directories.\<\/description\>\n\<\/property\>\n\<property\>\n\<name\>fs.default.name\<\/name\>\n\<value\>hdfs\:\/\/h1s1\:9000\<\/value>\n\<\/property\>\n" $hadoopHome/etc/hadoop/core-site.xml

# 配置hdfs-site.xml
sed -i "/<configuration>/a\ \n\<property\>\n\<name\>dfs.name.dir\<\/name\>\n\<value\>$hadoopHome/dfs/name\<\/value\>\n\<description\>Path on the local filesystem where theNameNode stores the namespace and transactions logs persistently.\<\/description\>\n\<\/property\>\n\<property\>\n\<name\>dfs.data.dir\<\/name\>\n\<value\>$hadoopHome/dfs/data\<\/value\>\n\<description\>Comma separated list of paths on the localfilesystem of a DataNode where it should store its blocks.\<\/description\>\n\<\/property\>\n\<property\>\n\<name\>dfs.replication\<\/name\>\n\<value\>2\<\/value\>\n\<\/property\>" $hadoopHome/etc/hadoop/hdfs-site.xml

# 配置mapred-site.xml
cp $hadoopHome/etc/hadoop/mapred-site.xml.template $hadoopHome/etc/hadoop/mapred-site.xml
sed -i "/<configuration>/a\ \n\<property\>\n\<name\>mapred.job.tracker\<\/name\>\n\<value\>$hn:49001\<\/value\>\n\<\/property\>\n\<property\>\n\<name\>mapred.local.dir\<\/name\>\n\<value\>$hadoopHome/var\<\/value\>\n\<\/property\>\n\<property\>\n\<name\>mapreduce.framework.name\<\/name\>\n\<value\>yarn\<\/value\>\n\<\/property\>"  $hadoopHome/etc/hadoop/mapred-site.xml

# 配置slaves文件

# 配置yarn-site.xml文件(选配)
echo "----------------------------------------------------------------------------"

# 格式化namenode
hadoop namenode format

# 删除本地安装文件
rm -rf *.tar.gz

# 启动hadoop
cd $hadoopHome/sbin/
bash start-dfs.sh
bash start-yarn.sh
jps
echo "----------------------------------------------------------------------------"

exit
