#include "initHead.h"
#include "queue.h"

void initQueue(QUEUE *q, int length)
{
	q->length = length;
	q->front = 0;
	q->rear = 0;
	q->NUM = (int *)malloc(sizeof(int) * length);
}

bool inQueue(QUEUE *q, int x)
{
	int tmp;
	if ((q->rear + 1) % q->length != q->front) {
		q->NUM[(q->rear)++] = x;
		q->rear = q->rear % q->length;	//防止rear溢出长度
		return true;
	}
	else {
		return false;
	}
}

bool outQueue(QUEUE *q, int *x)
{
	if (q->front != q->rear) {
		*x = q->NUM[(q->front)++];
		q->front = q->front % q->length;
		return true;
	}
	else {
		return false;
	}
}

void destoryQueue(QUEUE *S)
{
	free(S->NUM);
}

QUEUE creatQueue()
{
	int x;
	QUEUE q;
	do {
		out("请输入队列空间大小:__\b\b");
		in("%d", &x);
		if (x < 2) {
			puts("循环队列长度不能小于2");
		}
	} while (x < 2);
	initQueue(&q, x);
	
	out("请输入队列的元素(键入0结束入队列)");
	do{
		in("%d", &x);
	} while (x != 0 && inQueue(&q, x));
	return q;
}

void wipeQueue(QUEUE *q)
{
	int x;
	while (outQueue(q, &x)) {
		out("%d ", x);
	}
}