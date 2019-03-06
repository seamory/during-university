/*
	根据搜索位置插入新结点
*/

#include "initHead.h"
#include "linkedList.h"

void insertElementBLWH(NODE *head, int i, int x);
void insertElementBLWNH(NODE *head, int i, int x);

void linkedList_insertLoction(void)
{
	NODE *head;
	int i,x;
	head = creatLinkedListWH();

	do {
		out("请输入您想插入的结点位置:__\b\b");
		in("%d", &i);
		if (i < 1) {
			puts("在链表的有效长度范围内,链表的起始位置为1");
		}
	} while (i < 1);
	out("请输入您想插入的值:__\b\b");
	in("%d", &x);

	insertElementBLWH(head, i, x);
	traversalWH(head);
	pause;

}

/*
	如果在本函数的入口处修改限制条件，
	将允许在空链表中插入新结点
*/
void insertElementBLWH(NODE *head, int i, int x)
{
	NODE *p, *node;
	int loc = 0;
	p = head;
	while (loc != i && p ->next != NULL) {
		loc++;
		p = p->next;
	}
	if (loc == i) {
		node = newNode();
		node->data = x;
		node->next = p->next;
		p->next = node;
	}else {
		puts("选择的位置不存在，无法插入结点");
	}

}

void insertElementBLWNH(NODE *head, int i, int x)
{
	NODE *p, *node;
	int loc = 1;
	p = head;
	while (loc != i && p->next != NULL) {
		loc++;
		p = p->next;
	}
	if (loc == i) {
		node = newNode();
		node->data = x;
		node->next = p->next;
		p->next = node;
	}
	else {
		puts("选择的位置不存在，无法插入结点");
	}

}
