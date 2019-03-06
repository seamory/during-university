#include "initHead.h"
#include "stack.h"

void linkedStack_creatView()
{
	NODE *top;
	top = creatLinkedStack();
	wipeLinkedStack(top);
	pause;
}