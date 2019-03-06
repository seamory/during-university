/*
链栈
*/
#include "initHead.h"
#include "stack.h"

NODE *newLSNode(void)
{
	NODE *node;
	node = (NODE *)malloc(sizeof(NODE));
	node->next = NULL;
	return node;
}

void pushLS(NODE *top, int x)
{
	NODE *node;
	node = newLSNode();
	node->x = x;
	node->next = top->next;	//此处不可以省略
	top->next = node;
}

bool popLS(NODE *top, int *x)
{
	NODE *node;
	if (top->next) {
		node = top->next;
		top->next = node->next;
		*x = node->x;
		free(node);
		return true;
	}
	else {
		return false;
	}
}

NODE *creatLinkedStack(void)
{
	NODE *top;
	top = newLSNode();
	int x;
	out("请输入入栈元素(键入0结束入栈):__\b\b");
	in("%d", &x);
	while (x != 0) {
		pushLS(top, x);
		in("%d", &x);
	}
	return top;
}

void wipeLinkedStack(NODE *top)
{
	int x;
	while (popLS(top, &x)) {
		out("%d ", x);
	}
}