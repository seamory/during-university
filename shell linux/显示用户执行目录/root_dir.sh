#!/bin/bash
for username in $*
 do
  user=`cat /etc/passwd | awk -F ':' '{print $1}' | grep -w $username`
  if [ ${#user} == 0 ]
   then
    echo "$username not exist"
  else
    echo $username"'s running path is : "`cat /etc/passwd | grep ^$username | awk -F ':' '{print $6}'`
  fi
 done
