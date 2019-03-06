#include "initHead.h"
#include "linkedList.h"

void searchLoctionWH(NODE *head, int x);
void searchLoctionWNH(NODE *head, int x);

void linkedList_searchLoction(void)
{
	NODE *head;
	int x;
	head = creatLinkedListWH();

	out("当前新创建的链表长度为:%d \n", linkedListLengthWH(head));
	out("请输入您想查找的链表位置，查询正确返回位于该位置的值和地址:__\b\b");
	do {
		in("%d", &x);
		if (x < 1) {
			out("查询位置以1为起始，您的输入有误，请重新输入:__\b\b");
		}
	} while (x < 1);

	searchLoctionWH(head, x);

	pause;
}

void searchLoctionWH(NODE *head, int x)
{
	NODE *p;
	int i = 0;
	p = head;
	while (i != x && p->next != NULL) {
		p = p->next;
		i++;
	}
	if (i == x) {
		out("链表中的所查询位置的值为:%d,地址:%p \n", p->data, p);
	}
	else {
		out("未能找到指定位置,您输入的位置已经超出此链表最大长度。\n");
	}
}

void searchLoctionWNH(NODE *head, int x)
{
	NODE *p;
	int i = 1;
	p = head;
	while (i != x && p -> next!= NULL) {
		p = p->next;
		i++;
	}
	if (i == x) {
		out("链表中的所查询位置的值为:%d,地址:%p \n", p->data, p);
	}
	else {
		out("未能找到指定位置,您输入的位置已经超出此链表最大长度。\n");
	}
}