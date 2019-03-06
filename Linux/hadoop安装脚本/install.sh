#!/bin/bash

let size=`ls -all | grep all.tar.gz | gawk '{print $5}'`
echo $size

cp setup.sh install_hadoop.bin
cat all.tar.gz >> install_hadoop.bin

sed -i "s/size=0/size=$size/g" install_hadoop.bin