#!/bin/bash

function random(){
	if (( $[$2-$1] >= 0 )); then
		echo $[$RANDOM%($2-$1+1)+$1]
	else
		echo $[$RANDOM%($1-$2+1)+$2]
	fi
}

function randomThree(){
	if (( $[$2-$1+1] >= $3 || $[$1-$2+1] >= $3)); then
		for ((i=0; i<$3; i++)); do
			random[$i]=`random $1 $2`
			for ((j=0; j<i; j++)); do
				flag=0
				while [ ${random[$i]} == ${random[$j]} ]; do
					flag=1
					if [ $flag == 1 ]; then
						random[$i]=`random $1 $2`
						j=0
						continue
					fi
				done
			done	
		done

		for ((i=0; i<$3; i++)); do
			echo ${random[$i]}
			done
	else
		echo "超出范围"
	fi
}

if [ ${#1} == 0 ]; then
	randomThree 1 29 3
elif [ ${#2} == 0 ]; then
	randomThree 1 $1 3
elif [ ${#3} == 0 ]; then
	randomThree $1 $2 3
else
	randomThree $1 $2 $3
fi
