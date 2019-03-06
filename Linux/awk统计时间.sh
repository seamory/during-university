awk -F '\t' '
NR==FNR{tmp[$1]=tmp[$1]","$2}
NR!=FNR{
    time=0;
    IDTIME[$1]=0;
    Max[$1]=0;
    Data[$1]=""
    MaxData[$1]="";
    split(tmp[$1],ID,",");
    #print($0, length(ID));
    if(length(ID) < 2){
        next;
    } else {
        # ID begin with one;
        # for(i in ID){
        #     print($0,ID[i]);
        # }
        for(i=2; i<=length(ID); i++){
            yearStart=substr(ID[i-1],1,4);
            monthStart=substr(ID[i-1],5,2);
            dayStart=substr(ID[i-1],7,2);
            yearEnd=substr(ID[i],1,4);
            monthEnd=substr(ID[i],5,2);
            dayEnd=substr(ID[i],7,2);
            timeStart=strftime("%j",mktime(yearStart" "monthStart" "dayStart" 00 00 00"));
            timeEnd=strftime("%j",mktime(yearEnd" "monthEnd" "dayEnd" 00 00 00"));
            if(timeEnd-timeStart==1){
                if(match(Data[$1],ID[i-1])){
                    Data[$1]=Data[$1]","ID[i];
                } else {
                    Data[$1]=Data[$1]","ID[i-1]","ID[i];
                }
                IDTIME[$1]=IDTIME[$1]+1;
                if(IDTIME[$1]>Max[$1]){
                    MaxData[$1]=Data[$1];
                    Max[$1]=IDTIME[$1];
                }
            } else {
                Data[$1]="";
                IDTIME[$1]=0;
            }
        }
        IDTIME[$1]=Max[$1]+1;
    }
}
END{
    for(id in IDTIME){
        print(id, IDTIME[id],MaxData[id]);
    }
}
' MJXXB2017_TSG_IN_UNIQUE MJXXB2017_TSG_IN_ID


awk -F '\t' '
BEGIN{
    OFS="\t";
}
NR==FNR{
    date[$1]=date[$1]","$6;
    time[$1]=time[$1]","$7;
    state[$1]=state[$1]","$2;
}
NR!=FNR{
    idTime[$1]=0;
    idInState[$1]=0;
    idOutState[$1]=0;
    idDateState[$1]=0;
    split(date[$1],dates,",")
    split(time[$1],times,",");
    split(state[$1],states,",");
    if(length(times) < 2 && length(times)!=length(states)){

    } else {
        for(i=2; i<=length(times); i++){
            if(dates[i-1]==dates[i]){
                split(times[i-1],startTime,":");
                split(times[i],endTime,":");
                # print(startTime[1]" "startTime[2]" "startTime[3]);
                timeStart=mktime(dates[i-1]" "startTime[1]" "startTime[2]" "startTime[3]);
                timeEnd=mktime(dates[i]" "endTime[1]" "endTime[2]" "endTime[3]);
                timeDiff=timeEnd-timeStart;
                #print($1,timeStart,timeEnd,timeDiff);
                if(states[i-1]==1 && states[i]==2){
                    idTime[$1]=idTime[$1]+((strftime("%H",timeDiff)-8)*60*60+strftime("%M",timeDiff)*60+strftime("%S",timeDiff));
                } else if (states[i-1]==1 && states[i]==1) {
                    idInState[$1]=idInState[$1]+1;
                } else if (states[i-1]==2 && states[i]==2) {
                    idOutState[$1]=idOutState[$1]+1;
                } else if (states[i-1]==2 && states[i]==1) {

                }
            } else if(states[i-1]==1 && states[i]==2) {
                idDateState[$1]=idDateState[$1]+1;
            } else {

            }
        }
    }
}
END{
    for(id in idTime){
        print(id, int(idTime[id]/3600)":"int((idTime[id]%3600)/60)":"idTime[id]%60,idInState[id],idOutState[id],idDateState[id]);
    }
}
' MJXXB2017_TSG_dateformate_sort MJXXB2017_TSG_IN_ID


153020058 1846915 7  10