#!/bin/bash

MYSIZE=$(df -m|awk '/\/$|\/home/{print $4}')
echo $MYSIZE

df -m /home/ | awk '{print $4}' |grep -i
