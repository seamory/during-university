awk -F '###' '
BEGIN{}
NR==FNR{
    if(match($5,"借书")) {
        book[$4][$1]=$2;
        name[$1]=$2;
        count[$1]=1+count[$1];
    }
} NR!=FNR {
    if(match($5,"借书")) {
        for(i in book[$4]){
            person[$1][i]=1+person[$1][i];
            if(bookList[$1][i]==""){
                bookList[$1][i]="《"$4"》";
            } else {
                bookList[$1][i]=bookList[$1][i]" 《"$4"》";
            }
        }
    }
} END {
    for(i in name) {
        for(j in person[i]){
            if(i!=j){
                if(str==""){
                    str = name[j]"("j") "person[i][j]/count[i]" "bookList[i][j];
                } else {
                    str = name[j]"("j") "person[i][j]/count[i]" "bookList[i][j]", "str;
                }
            }
        }
        print(name[i],i" | "str);
        str="";
    }
}' 2017年借阅数据.txt 2017年借阅数据.txt | grep "^姓名"


awk -F '###' '  # 文件分隔符为"###"
BEGIN{} # 预留BEGIN命令用于调整输出时字符分割以及行记录分割符
NR==FNR{    # 通过NR与FNR来awk当前读取的文件是否为第一个文件
    if(match($5,"借书")) {  # 通过match判断当前读取的记录是否为借书记录
        book[$4][$1]=$2;    # 创建二维数据,一维为图书名称,二维为学号
        name[$1]=$2;    # 创建学号姓名索引
        count[$1]=1+count[$1];  # 根据学号统计借阅总数用于计算契合度
    }
} NR!=FNR { # 通过NR与FNR来awk当前读取的文件是否为第二个文件
    if(match($5,"借书")) {  # 通过match判断当前读取的记录是否为借书记录
        for(i in book[$4]){ # 根据一维图书名称获取借阅此图书的所有人,并对其进行迭代,i为学号即二维的键值
            person[$1][i]=1+person[$1][i];  # 计算借阅图书相同的人的相同次数,一维为当前的学号,二维为借书记录中存在的学号
            if(bookList[$1][i]==""){    # 获取借阅图书相同的人的相同书籍名称,一维为当前的学号,二维为借书记录中存在的学号(为了防止出现首尾的字符分隔符,采用if进行判断),如果为空则初始化值,如果不为空则追加值.
                bookList[$1][i]="《"$4"》"; # 初始化书名
            } else {
                bookList[$1][i]=bookList[$1][i]" 《"$4"》"; # 追加书名
            }
        }
    }
} END { # awk收尾工作
    for(i in name) {    # 遍历学号姓名索引,i为当前用户学号
        for(j in person[i]){    # 遍历借阅图书相同的人的相同次数的数组,获得有缘人的学号
            if(i!=j){   # 排除自身数据
                if(str==""){    # 构造输出对象
                    str = name[j]"("j") "person[i][j]/count[i]" "bookList[i][j];
                } else {
                    str = name[j]"("j") "person[i][j]/count[i]" "bookList[i][j]", "str;
                }
            }
        }
        print(name[i],i" | "str);   # 输出结果
        str=""; # 重置str
    }
}' 2017年借阅数据.txt 2017年借阅数据.txt | grep "^姓名"