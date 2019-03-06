#!/bin/bash

sum=0
for((i=0;i<=50;i++))
 do
  if (( $i%2 == 0 ))
   then
    let sum=i+sum
  fi
done
echo $sum
