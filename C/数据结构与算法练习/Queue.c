#ifndef QUEUE_H
#define QUEUE_H
/*
	本例采用牺牲法 将会导致数组比length少1
	rear始终指向队尾元素（如果存在)的下一位
	front始终指向队首元素
 */
#include <stdio.h>
#include <stdlib.h>

typedef enum{false, true} bool;

typedef struct queue{
	int length;
	int front;
	int rear;
	int *NUM;
} QUEUE;

void initQueue(QUEUE *q, int length)
{
	q -> length = length;
	q -> front = 0;
	q -> rear = 0;
	q -> NUM = (int *)malloc(sizeof(int) * length);
}

bool inQueue(QUEUE *q, int x)
{	
	int tmp;
	if((q -> rear + 1) % q -> length != q -> front){
		q -> NUM[(q -> rear)++] = x;
		q -> rear = q -> rear % q -> length;	//防止rear溢出长度
		return true;
	}else{
		return false;
	}
}

bool outQueue(QUEUE *q, int *x)
{
	if( q -> front  != q -> rear){
		*x = q -> NUM[(q -> front)++];
		q -> front = q -> front % q -> length;
		return true;
	}else{
		return false;
	}
}

void destoryQueue(QUEUE *S)
{
	free(S -> NUM);
}
#endif

int main()
{
	QUEUE S;
	int i, tmp;
	initQueue(&S, 10);
	for(i = 0; i < 10; i++){
		inQueue(&S, i);
	}
	for(i = 0; i < 5; i++){
		if(outQueue(&S, &tmp))
			printf("%d ", tmp);
	}
	printf("\n");
	
	for(i = 10; i < 15; i++){
		inQueue(&S, i);
	}
	for(i = 0; i < 10; i++){
		if(outQueue(&S, &tmp))
			printf("%d ", tmp);
	}
	printf("\n");
	return 0;
}