#!/bin/bash
#   GH 2018-04-05 01:38:32
#   请在SSD或者更高速的设备中运行此脚本

starttime=$(date +'%Y-%m-%d %H:%M:%S')

echo "+---------------------------------------------------------------------+"
echo "|              ggggggggggg                  hhhhhh       hhhhhh       |"
echo "|          gggggggggggggggggg              hhhhhh       hhhhhh        |"
echo "|        ggggggg          ggggg           hhhhhh       hhhhhh         |" 
echo "|       ggggggg          gggggg           hhhhhh       hhhhhh         |"
echo "|       gggggg           gggggg          hhhhhhhhhhhhhhhhhhh          |"
echo "|      gggggg                            hhhhhhhhhhhhhhhhhh           |"
echo "|      ggggggg     ggggggggggg          hhhhhhhhhhhhhhhhhh            |"
echo "|       gggggg         gggggg          hhhhhh       hhhhhh            |"
echo "|        gggggg        gggg           hhhhhh       hhhhhh             |"
echo "|          gggggggggggggg             hhhhhh       hhhhhh             |"
echo "|             ggggggg                hhhhhh       hhhhhh              |"
echo "+---------------------------------------------------------------------+"
echo "======================================================================="
echo "注意事项："
echo "1. 请确保所有文件的编码格式为UTF-8无BOM格式"
echo "2. 请确保已经图书清单数据转为txt文件，并且命名位booklist_x的格式(x表示从1开始的自然数序列)"
echo "3. 请确保硬盘至少有20GB的可用空间"
echo "   如果上述有任何一项条件无法达到,请使用ctrl+c取消任务"
echo "======================================================================="
# 清除缓存文件依赖
echo "清除缓存文件依赖"
rm -rf ./data
echo "清理数据存放位置"
rm -rf ./result

# 创建缓存文件依赖
echo "创建缓存文件依赖"
mkdir -m 777 ./data
echo "创建数据存放位置"
mkdir -m 777 ./result

# 处理图书记录数据
echo "合并图书记录数据"
cat booklist_1 booklist_2 booklist_3 booklist_4 > ./data/booklist.data &

# 处理图书馆数据
# 如果需要使用图书馆数据记录的最后一行,请将本处理下的最后一句改为:
# awk 'BEGIN{ORS="\t\n"}{print $0}' > ./data/tsg.data &
# 其他预处理同理
echo "处理图书数据格式"
awk -F '(' '{print $2}' v_tsg_jylog.sql | \
awk -F ')' '{print $1}' | \
sed "s/'//g" | \
sed "s/, /\t/g" | \
awk '{print $0}' > ./data/tsg.data &

# 处理门禁数据(name,id)
echo "处理门禁数据格式"
awk -F '(' '{print $2}' MJXXB.sql | \
awk -F ')' '{print $1}' | \
sed "s/'//g" | \
sed "s/, /\t/g" | \
awk '{print $0}' > ./data/mj.data &

# 处理饭卡消费数据
echo "处理饭卡数据格式"
awk -F '(' '{print $2}' YKTYHXFSJZL_NEW.sql | \
awk -F ')' '{print $1}' | \
sed "s/'//g" | \
sed "s/, /\t/g" | \
awk '{print $0}' > ./data/fk.data &

# 等待所有线程返回
echo "等待线程数据返回"
wait

# 生成姓名数据
echo "生成姓名缓存数据"
awk -F '\t' '{print $1"\t"$2}' ./data/tsg.data > ./data/name.tmp
echo "生成姓名索引数据"
sort -u ./data/name.tmp > ./data/name.data

# 生成图书馆记录
# BB    姓名    学号    操作类型    图书查询号  图书价格    操作日期
# 使用$10, $11 规避Bom
# 单价使用$7 规避末尾\n 或者在数据预处理的时候修改记录分隔符
echo "生成图书馆记录"
awk -F '\t' 'NR==FNR{book[$6]=$10;price[$6]=$7;} NR!=FNR{print "BB\t"$1"\t"$2"\t"$4"\t"book[$5]"\t"price[$5]"\t"$7}' ./data/booklist.data ./data/tsg.data > ./result/tsg.data &

# 生成门禁记录
# EG    姓名    学号    刷卡日期    刷卡时间  
echo "生成门禁记录"
awk -F '\t' 'NR==FNR{name[$2]=$1} NR!=FNR{print "EG\t"name[$1]"\t"$1"\t"$6"\t"$7}' ./data/name.data ./data/mj.data > ./result/mj.data &

# 生成学生成绩记录
# SS    姓名    学号    正考成绩    补考成绩    学年
# 注意BOM会导致出错
echo "生成学生成绩记录"
awk -F '\t' 'NR==FNR{name[$2]=$1} NR!=FNR{if($1!="XH"){print "SS\t"name[$1]"\t"$1"\t"$6"\t"$7"\t"$3}}' ./data/name.data ./xueshengchengji.tsv > ./result/cj.data &

# 处理饭卡消费
echo "生成饭卡消费记录"
# MC    姓名    学号    余额    充值额  操作类型    时间
awk -F '\t' 'NR==FNR{name[$2]=$1} NR!=FNR{if($19!="NULL"){print "MC\t"name[$19]"\t"$19"\t"$12"\t"$13"\t"$21"\t"$11}}' ./data/name.data ./data/fk.data > ./result/fk.data &

# 等待所有线程返回
echo "等待线程数据返回"
wait

# 合并数据
echo "合并数据"
cat ./result/* > all.data

# 运行结束
endtime=$(date +'%Y-%m-%d %H:%M:%S')
start_seconds=$(date --date="$starttime" +%s)
end_seconds=$(date --date="$endtime" +%s)
echo "Finished:"$((end_seconds-start_seconds))"s"