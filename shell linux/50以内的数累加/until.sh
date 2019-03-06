#!/bin/bash

i=0
sum=0
until $i==50
do
 if (($i%2 == 0))
 then
  sum=$(($sum + $i))
 fi
 let i=i+1
done
echo $sum