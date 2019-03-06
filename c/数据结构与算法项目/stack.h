#pragma once
#ifndef __STACK_H
#define __STACK_H

#include "initHead.h"

typedef struct node {
	int x;
	struct node * next;
} NODE;

typedef struct stack {
	int length;
	int top;
	int base;
	int *NUM;
} STACK;

void initStack(STACK *s, int length);
bool push(STACK *s, int x);
bool pop(STACK *s, int *x);
void destoryStack(STACK *s);
STACK creatStack(void);
void wipeStack(STACK *s);

NODE *newLSNode(void);
void pushLS(NODE *top, int x);
bool popLS(NODE *top, int *x);
NODE *creatLinkedStack(void);
void wipeLinkedStack(NODE *top);

#endif // !STACK
