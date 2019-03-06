#include "initHead.h"
#include "queue.h"

void cirularQueue_creatView(void)
{
	QUEUE q;
	int x, y, i = 0;
	puts("默认使用牺牲法，有效可用存储单元为队列长度减1");
	puts("队列生成与清空:");
	q = creatQueue();
	out("清空队列 ; ");
	wipeQueue(&q);
	flush;

	pause;
	system("cls");
	out("\n\n队列出入队列功能:");
	out("\n请输入入队列元素（空格隔开,键入0结束入队列）: __\b\b");
	do {
		in("%d", &x);
	} while (x != 0 && inQueue(&q, x));

	out("\n请输入要出队列的元素数(超过队列长队将默认全部出队列):__\b\b");
	in("%d", &y);
	while (outQueue(&q, &x) && i < y) {
		out("%d ", x);
		i++;
	}

	pause;
}