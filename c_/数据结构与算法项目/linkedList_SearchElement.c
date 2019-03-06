#include "initHead.h"
#include "linkedList.h"

void searchElementWH(NODE *head, int x);
void searchElementWNH(NODE *head, int x);

void linkedList_searchElement(void)
{
	NODE *head;
	int x;
	head = creatLinkedListWH();

	out("当前新创建的链表长度为:%d \n", linkedListLengthWH(head));
	out("请输入您想在链表中查找的值，查询正确将返回元素在链表中的位置和地址:__\b\b");
	in("%d", &x);

	searchElementWH(head, x);

	pause;
}

void searchElementWH(NODE *head, int x)
{
	NODE *p;
	int i = 0;
	p = head;
	while (p->next != NULL && p ->data != x ) {
		p = p->next;
		i++;
	}
	if (p ->data == x) {
		out("查找的值在链表中的位置为:%d,地址:%p \n", i, p);
	}
	else {
		out("未能找到指定值,查找元素不存在于此链表中。\n");
	}
}

void searchElementWNH(NODE *head, int x)
{
	NODE *p;
	int i = 1;
	p = head;
	while (p->next != NULL && p ->data != x ) {
		p = p ->next;
		i++;
	}
	if (p->data == x) {
		out("查找的值在链表中的位置为:%d,地址:%p \n", i, p);
	}
	else {
		out("未能找到指定值,查找元素不存在于此链表中。\n");
	}
}