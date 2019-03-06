/*
	删除指定位置的结点
*/

#include "initHead.h"
#include "linkedList.h"

void deleteLoctionWH(NODE *head, int x);

void linkedList_deleteLoction()
{
	NODE *head;
	int x;
	head = creatLinkedListWH();
	do {
		out("请输入删除的位置:__\b\b");
		in("%d", &x);
		if (x < 1) {
			puts("链表起始位置为1,请输入有效位置");
		}
	} while (x < 1);

	deleteLoctionWH(head, x);
	traversalWH(head);
	
	pause;
}

void deleteLoctionWH(NODE *head, int x)
{
	NODE *p, *t;
	int i = 1;
	p = head;
	while (p -> next != NULL && i != x) {
		p = p->next;
		i++;
	}
	if (i == x && p->next) {
		t = p->next;
		p->next = p->next->next;
		free(t);
	}
	else {
		puts("指定位置不存在，删除失败.");
	}
}