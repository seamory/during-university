/*
	删除链表中存在指定元素的所有结点
*/

#include "initHead.h"
#include "linkedList.h"

void deleteElementWH(NODE *head, int x);

void linkedList_deleteElement()
{
	NODE *head;
	int x;
	head = creatLinkedListWH();

	out("请输入删除的值:__\b\b");
	in("%d", &x);

	deleteElementWH(head, x);
	traversalWH(head);

	pause;
}

void deleteElementWH(NODE *head, int x)
{
	NODE *p, *t;
	int i = 0;
	p = head;
	while (p->next != NULL) {
		if (p->next->data == x) {
			t = p->next;
			p->next = t->next;
			free(t);
			i++;
		}
		else {
			p = p->next;
		}
	}
	if (i) {
		out("已从当前链表中删除值为: %d 的结点 %d 个\n", x, i);
	}
	else {
		puts("当前链表中不存在输入值,删除结点0个");
	}
}

