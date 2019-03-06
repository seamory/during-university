#ifndef STACK_H
#define STACK_H
#include <stdio.h>
#include <stdlib.h>
/*
	栈总高度为实际元素容纳量
	top始终指向栈顶元素的下一个位置
	base与top指针皆指向0位置
	默认情况下
		判空条件 : top = 0
		判满条件 : top = max
 */
 
typedef enum{false, true} bool;
typedef bool BOOL;
typedef struct stack{
	int length;
	int top;
	int base;
	int *NUM;
} STACK;

void initStack(STACK *s, int length)
{
	s -> length = length;
	s -> top = 0;
	s -> base = 0;
	s -> NUM = (int *)malloc(sizeof(int) * length);
}

bool push(STACK *s, int x)
{
	if(s -> top != s -> length){
		s -> NUM[(s -> top)++] = x;
		return true;
	}else{
		return false;
	}
}

bool pop(STACK *s, int *x)
{
	if(s -> top != s -> base){
		*x = s -> NUM[--(s -> top)];
		return true;
	}else{
		return false;
	}
}

void destoryStack(STACK *s)
{
	free(s -> NUM);
}
#endif

int main()
{
	STACK S;
	int i, tmp;
	initStack(&S, 10);
	for(i = 0; i < 10; i++){
		if(!push(&S, i))
			puts("push failed");
	}
	for(i = 0; i < 10; i++){
		if(pop(&S, &tmp))
			printf("%d ", tmp);
		else
			puts("pop failed");
	}
}