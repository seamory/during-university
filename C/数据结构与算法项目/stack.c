#include "initHead.h"
#include "stack.h"

/*
	数组构建的顺序栈
*/
void initStack(STACK *s, int length)
{
	s->length = length;
	s->top = 0;
	s->base = 0;
	s->NUM = (int *)malloc(sizeof(int) * length);
}

bool push(STACK *s, int x)
{
	if (s->top != s->length) {
		s->NUM[(s->top)++] = x;
		return true;
	}
	else {
		return false;
	}
}

bool pop(STACK *s, int *x)
{
	if (s->top != s->base) {
		*x = s->NUM[--(s->top)];
		return true;
	}
	else {
		return false;
	}
}

void destoryStack(STACK *s)
{
	free(s->NUM);
}

STACK creatStack(void)
{
	STACK s;
	int l, x;
	out("请输入栈的大小:__\b\b");
	in("%d", &l);
	initStack(&s, l);
	flush;

	out("请依次输入入栈元素(键入0结束入栈):__\b\b");
	in("%d", &x);
	while (x != 0 && push(&s, x)) {
		in("%d", &x);
	}
	return s;
}

void wipeStack(STACK *s)
{
	int x;
	while (pop(s, &x)) {
		out("%d ", x);
	}
}