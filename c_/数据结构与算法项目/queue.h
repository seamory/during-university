#pragma once
#ifndef __QUEUE_H_
#define __QUEUE_H_

#include "initHead.h"

typedef struct queue {
	int length;
	int front;
	int rear;
	int *NUM;
} QUEUE;

typedef struct node {
	int data;
	struct node * next;
} queueNode;

void initQueue(QUEUE *q, int length);
bool inQueue(QUEUE *q, int x);
bool outQueue(QUEUE *q, int *x);
void destoryQueue(QUEUE *S);
QUEUE creatQueue(void);
void wipeQueue(QUEUE *q);

queueNode *newLQNode();
void inLinkedQueue(queueNode **rear, int x);
bool outLinkedQueue(queueNode *front, queueNode **rear, int *x);
void creatLinkedQueue(queueNode **rear);
void wipeLinkedQueue(queueNode *front, queueNode **rear);

#endif // !__QUEUE_H_
