#include "initHead.h"
#include "queue.h"

void linkedQueue_creatView(void)
{
	queueNode *front, *rear;
	front = newLQNode();
	rear = front;
	puts("队列生成与清空:");
	creatLinkedQueue(&rear);
	out("清空队列 : ");
	wipeLinkedQueue(front, &rear);
	pause;
}