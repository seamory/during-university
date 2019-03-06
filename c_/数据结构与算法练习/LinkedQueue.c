/*
	默认创建带头结点的队列
	创建一个deleteHead的函数用以支持删除队首
 */

#ifndef LINKEDQUEUE_H
#define LINKEDQUEUE_H
#include <stdio.h>
#include <stdlib.h>

typedef enum{false, true} bool;

typedef struct node{
	int data;
	struct node * next;
} NODE;

NODE *creatNode()
{
	NODE *node;
	node = (NODE *)malloc(sizeof(NODE));
	node -> next =NULL;
	return node;
}

void inQueue(NODE **rear, int x)
{
	NODE *node;
	node = creatNode();
	node ->  data = x;
	node -> next = (*rear) -> next;
	(*rear) -> next = node;
	*rear = node;
}

bool outQueue(NODE *front, NODE **rear, int *x)
{
	NODE *node;
	if(front -> next){
		node = front -> next;
		*x = node -> data;
		front -> next = node -> next;
		if(node -> next == NULL){
			*rear = front;
		}
		free(node);
		return true;
	}else{
		return false;
	}
}

#endif

int main()
{
	NODE *front, *rear;
	front = creatNode();
	rear = front;
	int i, tmp;
	for(i = 0; i < 10; i++){
		inQueue(&rear, i);
	}
	for(i = 0; i < 10; i++){
		if(outQueue(front, &rear, &tmp))
			printf("%d ", tmp);
	}
	printf("\n");
	
	for(i = 10; i < 30; i++){
		inQueue(&rear, i);
	}
	for(i = 0; i < 7; i++){
		if(outQueue(front, &rear, &tmp)){
			printf("%d ", tmp);
		}
	}
	printf("\n");
	return 0;
}