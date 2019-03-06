#include "initHead.h"
#include "queue.h"


queueNode *newLQNode()
{
	queueNode *node;
	node = (queueNode *)malloc(sizeof(queueNode));
	node->next = NULL;
	return node;
}

void creatLinkedQueue(queueNode **rear)
{
	int x;
	puts("请输入入队列的元素,键入0结束入队列:");
	in("%d", &x);
	while (x) {
		inLinkedQueue(rear, x);
		in("%d", &x);
	}
}

void inLinkedQueue(queueNode **rear, int x)
{
	queueNode *node;
	node = newLQNode();
	node->data = x;
	node->next = (*rear)->next;
	(*rear)->next = node;
	*rear = node;
}

bool outLinkedQueue(queueNode *front, queueNode **rear, int *x)
{
	queueNode *node;
	if (front->next) {
		node = front->next;
		*x = node->data;
		front->next = node->next;
		if (node->next == NULL) {
			*rear = front;
		}
		free(node);
		return true;
	}
	else {
		return false;
	}
}

void wipeLinkedQueue(queueNode *front, queueNode **rear)
{
	int x;
	while (outLinkedQueue(front, rear, &x)) {
		out("%d ", x);
	}
}