awk -F ',' '
BEGIN{
OFS=",";
}{
    name[$1]=$2;
    time[$1]=time[$1]","$3;
}END{
    for(id in name){
        split(time[id],times,",");
        max[id]=0;
        start[id]="";
        end[id]="";
        if(length(times)>3){
            for(i=3; i<length(times); i++){
                timeStart = mktime(times[i-1]" 00 00 00");
                timeEnd = mktime(times[i]" 00 00 00");
                timeDiff = timeEnd - timeStart;
                if (max[id] <= timeDiff) {
                    max[id]=timeDiff;
                    start[id]=times[i-1];
                    end[id]=times[i];
                }
            }
        } else {
            max[id] = mktime("2018 01 01 00 00 00") - mktime(times[2]" 00 00 00");
            start[id] = times[2];
            end[id] = "2017 12 13";
        }
        print(id, name[id], max[id]/86400, start[id], end[id]);
    }
}' 计算时间间隔.txt | grep "153020058"