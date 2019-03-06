#!/bin/bash

echo -n "Please input your number:"
read number
echo -n  "Please input your name:"
read name
echo "Your number is : $number; name is $name "

if [ $number -eq '1' -o $number -eq '10' ]
 then
  echo "He is a teacher"
elif [ $number -eq '2' -o $number -eq '20' ]
 then
  echo "He is a doctor"
fi

echo -n "Please input your number(1-7):"
read day
case $day in
1)
 echo "xingQi1";;
2)
 echo "xingQi2";;
3)
 echo "xingQi3";;
4)
 echo "xingQi4";;
5)
 echo "xingQi5";;
6)
 echo "xingQi6";;
7)
 echo "xingQi7";;
*)
 ;;
esac
