#!/bin/bash

echo -n "Please input the username:"
read username
user=`cat /etc/passwd | awk -F ':' '{print $1}' | grep -w $username`
if [ ${#user} == 0 ]
 then
  echo "$username not exist"
else
  echo `cat /etc/passwd | grep ^$username | awk -F ':' '{print $6}'`
fi
