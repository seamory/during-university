#include "initHead.h"
#include "stack.h"

void stack_creatView(void)
{
	STACK s;
	s = creatStack();
	wipeStack(&s);
	pause;
}