#!/bin/bash

function getRandom(){
	i=0;
	for num in `seq $1 $2`; do
		array[i++]=$num
	done

	#while (( ${#array[*]} > 0)); do
	for ((len=0; len<$3; len++)); do
		index=$[$RANDOM%${#array[*]}]
		echo ${array[$index]}
		j=0
		for ((i=0; i<${#array[*]}; i++)); do
			if [ $i != $index ]; then
				array[j++]=${array[$i]}
			fi
		done
		unset array[$[${#array[*]}-1]]

	done
}

function check(){
	if (( $[$2-$1+1] < $3 )); then
		echo "范围错误"
		exit
	fi
}

if [ "$#" == "0" ]; then
	getRandom 1 100 3
elif [ "$#" == "1" ]; then
	check 1 $1 1 
	getRandom 1 $1 1
elif [ "$#" == "2" ]; then
	check $1 $2 1
	getRandom $1 $2 1
elif [ "$#" == "3" ]; then
	check $1 $2 $3
	getRandom $1 $2 $3
fi
