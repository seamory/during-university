/*
	通过查找指定元素值插入新结点
*/

#include "initHead.h"
#include "linkedList.h"

void insertElementBEWH(NODE *head, int x, int n);
void insertElementBEWNH(NODE *head, int x, int n);

void linkedList_insertElement(void)
{
	NODE *head;
	int x, n;
	head = creatLinkedListWH();
	out("请输入查找的元素:__\b\b");
	in("%d", &x);
	out("请输入插入的元素:__\b\b");
	in("%d", &n);
	insertElementBEWH(head, x, n);
	traversalWH(head);
	pause;
}

void insertElementBEWH(NODE *head, int x, int n)
{
	NODE *p, *node;
	int flag = 1;
	p = head -> next;
	while (p != NULL) {
		if ( p->data == x) {
			flag = 0;
			node = newNode();
			node->data = n;
			node->next = p->next;
			p->next = node;
			p = node; //防止进入死循环
		}
		p = p->next;
	}
	if (flag) {
		puts("所查询链表中无指定元素，未能完成插入,请重试");
	}
}

void insertElementBEWNH(NODE *head, int x, int n)
{
	NODE *p, *node;
	int flag = 1;
	p = head;
	while (p != NULL) {
		if (p->data == x) {
			flag = 0;
			node = newNode();
			node->data = n;
			node->next = p->next;
			p->next = node;
			p = node; //防止进入死循环
		}
		p = p->next;
	}
	if (flag) {
		puts("所查询链表中无指定元素，未能完成插入,请重试");
	}
}