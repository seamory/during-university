/*
	默认创建带头结点的栈
	后期通过函数将其头结点
 */
#ifndef LINKEDSTACK_H
#define LINKEDSTACK_H
#include <stdio.h>
#include <stdlib.h>

typedef enum{false, true} bool;
typedef bool BOOL;
typedef struct node{
	int x;
	struct node * next;
} NODE;

NODE *creatNode(void)
{
	NODE *node;
	node = (NODE *)malloc(sizeof(NODE));
	node -> next = NULL;
	return node;
}

void push(NODE *top, int x)
{
	NODE *node;
	node = (NODE *)malloc(sizeof(NODE));
	node -> x = x;
	node -> next = top -> next;	//此处不可以省略
	top -> next = node;
}

bool pop(NODE *top, int *x)
{
	NODE *node;
	if(top -> next){
		node = top -> next;
		top -> next = node -> next;
		*x = node -> x;
		free(node);
		return true;
	}else{
		return false;
	}
}

#endif

int main()
{
	NODE *top;
	top = creatNode();
	int i, tmp;
	for(i = 0; i < 10; i++){
		push(top, i);
	}
	for(i = 0; i < 11; i++){
		if(pop(top, &tmp))
			printf("%d ", tmp);
		else
			puts("pop failed");
	}
}