#!/bin/bash
echo "请将图书数据文件另存为txt文件,请去除空行和索引号,并重命名为booklist_x的格式,x为自然数列"
echo "======================================================================================="
echo -n "是否清空缓存文件以及数据结果文件:(1=yes,0=no)"
starttime=`date +'%Y-%m-%d %H:%M:%S'`
read dec
if [ $dec -eq "1" ]; then
    if [ -d "./tmp_book" ]; then
        rm -rf ./tmp_book
        mkdir -m 777 ./tmp_book
    fi
    if [ -d "./tmp_student" ]; then
        rm -rf ./tmp_student
        mkdir -m 777 ./tmp_student
    fi
    if [ -d "./tmp_result" ]; then
        rm -rf ./tmp_result
        mkdir -m 777 ./tmp_result
    fi
elif [ $dec -eq "0" ]; then
    if [ ! -d "./tmp_book" ]; then
        mkdir -m 777 ./tmp_book
    fi
    if [ ! -d "./tmp_student" ]; then
        mkdir -m 777 ./tmp_student
    fi
    if [ ! -d "./tmp_result" ]; then
        mkdir -m 777 ./tmp_student
    fi
else
	#计算执行时间
	endtime=`date +'%Y-%m-%d %H:%M:%S'`
	start_seconds=$(date --date="$starttime" +%s);
	end_seconds=$(date --date="$endtime" +%s);
	echo "本次运行时间： "$((end_seconds-start_seconds))"s"
	exit
fi

echo "===========================生成图书索引数据============================="
# 处理图书索引数据
awk -F '\t' '{print $1","$7 >> "./tmp_book/"$6}' booklist_1
awk -F '\t' '{print $1","$7 >> "./tmp_book/"$6}' booklist_2
awk -F '\t' '{print $1","$7 >> "./tmp_book/"$6}' booklist_3
awk -F '\t' '{print $1","$7 >> "./tmp_book/"$6}' booklist_4
# 处理图书索引数据完毕
echo "=========================图书索引数据生成完成============================="
#
echo "=======================生成数据索引数据并产生借阅结果========================="
# 处理图书馆借阅数据同时获取学生姓名(姓名,学号)
awk -F '(' '{print $2}' v_tsg_jylog.sql | \
awk -F ')' '{print $1}' | \
sed "s/'//g" | \
awk -F ', ' '{ print $1 > "./tmp_student/"$2 ; print $0}' | \
awk -F ', ' '{ system("if [ -f ./tmp_book/"$5" ]; then book=$(cat ./tmp_book/"$5"); echo "$1"\t"$2"\tBB:"$4",$book,"$7" >> ./tmp_result/"$2"; else echo "$1"\t"$2"\tBB:"$4",0,0,"$7" >> ./tmp_result/"$2"; fi") }'
# awk -F ', ' '{ $filed=$0; $command="test -e ./tmp_book/"$5" && echo 1 || echo 0"; $file=system($command); $fileds; if($file==1){$book=$(cat "./tmp_book/"$5); print $1"\t"$2"\tBB:"$4","$book","$7 >> "./tmp_result/"$2}else{ print $0; print $1"\t"$2"\tBB:"$4","0,0","$7 >> "./tmp_result/"$2}}'
#awk -F ', ' '{$book=$(cat "./tmp_book/"$5); print $1"\t"$2"\tBB:"$4","$book","$7 >> "./tmp_result/"$2}'
#awk -F ', ' '{print $1"\t"$2"\tBB:"$4","$7 >> "./tmp_result/"$2}'
# 图书馆借阅数据处理完成学生姓名获取完成
echo "=====================生成数据索引数据并产生借阅结果完成========================="
#
echo "=================================生成门禁数据================================"
# 处理门禁数据(name,id)
awk -F '(' '{print $2}' MJXXB.sql | \
awk -F ')' '{print $1}' | \
sed "s/'//g" | \
awk -F ', ' '{ system("if [ -f ./tmp_student/"$1" ]; then name=$(cat ./tmp_student/"$1"); echo $name\t"$1"\tEG:"$6","$7" >> ./tmp_result/"$1"; else echo "$1"\t"$1"\tEG:"$6","$7" >> ./tmp_result/"$1"; fi") }'
# awk -F ', ' '{ $name=$(cat "./tmp_student/"$1); print $1"\t"$name"\tEG:"$6","$7 >> "./tmp_result/"$1}'
# 门禁数据处理完成
echo "==============================门禁数据处理完成================================"
#
echo "==============================生成学生成绩数据================================"
# 处理学生成绩数据
awk -F '\t' '{ system("if [ -f ./tmp_student/"$1" ]; then name=$(cat ./tmp_student/"$1"); echo $name\t"$1"\tSS:"$6","$7","$3" >> ./tmp_result/"$1"; else echo "$1"\t"$1"\tSS:"$6","$7","$3" >> ./tmp_result/"$1"; fi") }' xueshengchengji.tsv
#awk -F '\t' '{$student=$(cat "./tmp_student/"$1); print $student"\tSS:"$6","$7","$3 >> "./tmp_result/"$1}'
# 学生成绩数据处理完成
echo "============================学生成绩数据处理完成=============================="
#
echo "============================生成学生饭卡消费数据================================"
# 处理饭卡消费数据
awk -F '(' '{print $2}' YKTYHXFSJZL_NEW.sql | \
awk -F ')' '{print $1}' | \
sed "s/'//g" | \
awk -F ', ' '{ system("if [ "$19"==NULL ]; then echo NULL\tNULL\tMC:"$12","$13","$21","$11" >> ./tmp_result/0; exit; fi; if [ -f ./tmp_student/"$19" ]; then name=$(cat ./tmp_student/"$19"); echo $name\t"$19"\tMC:"$12","$13","$21","$11" >> ./tmp_result/"$19"; else echo "$19"\t"$19"\tMC:"$12","$13","$21","$11" >> ./tmp_result/"$19"; fi") }'
#awk -F ', ' '{$student=$(cat "./tmp_student/"$19); print $student"\tMC:"$13","$21","$11 >> "./tmp_result/"$19}'
# 饭卡消费数据处理完成
echo "=========================学生饭卡消费数据处理完成================================"
# 删除冗余数据
rm -rf ./tmp_result/0
rm -rf ./tmp_result/XH
# 计算执行时间
endtime=`date +'%Y-%m-%d %H:%M:%S'`
start_seconds=$(date --date="$starttime" +%s);
end_seconds=$(date --date="$endtime" +%s);
echo "本次运行时间： "$((end_seconds-start_seconds))"s"
