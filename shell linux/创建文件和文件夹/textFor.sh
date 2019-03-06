#!/bin/bash

mkdir test_for
cd test_for
mkdir backup

for((i=0;i<=30;i++))
do
  mkdir $i"test"
done

for((i=0;i<20;i++))
do
 touch $i"txt"
 if [ -f $i"txt" ]
 then
  mv $i"txt" backup
 fi
done

cd backup
for i in 0txt 8txt 9txt 18txt
 do
  case $i in
   "0txt")
   mv 0txt 00txt;;
   "8txt")
   mv 8txt 88txt;;
   "9txt")
   mv 9txt 99txt;;
   "18txt")
   mv 18txt 1818txt;;
   *)
   ;;
   esac
done
