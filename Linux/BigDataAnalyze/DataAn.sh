#!/bin/bash

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

# 选择开启导出分析数据字段
## 导出饭卡操作
awk -F '\t' '{print $21}' ./data/fk.data > ./data/fkOperation.tmp
sort -u ./data/fkOperation.tmp > ./data/fkOperation.data
## 导出图书馆操作
awk -F '\t' '{print $4}' ./data/tsg.data > ./data/tsgOperation.tmp
sort -u ./data/tsgOperation.tmp > ./data/tsgOperation.data
## 导出成绩等级
awk -F '\t' '{print $6}' ./xueshengchengji.tsv > ./data/cjLevel.tmp
sort -u ./data/cjLevel.tmp > ./data/cjLevel.data

endtime=$(date +'%Y-%m-%d %H:%M:%S')
start_seconds=$(date --date="$starttime" +%s)
end_seconds=$(date --date="$endtime" +%s)
echo "Finished:"$((end_seconds-start_seconds))"s"