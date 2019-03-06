/*
	构建两个无序链表，并合并为一条有序链表
*/

#include "initHead.h"
#include "linkedList.h"

void sorted(NODE *head, char flag);
NODE *sortedMerge(NODE *one, NODE *two, char flag);

void linkedList_sortedMerge(void)
{
	NODE *one, *two, *head;
	char flag;
	puts("请建立第一张链表");
	one = creatLinkedListWH();
	puts("请建立第二张链表");
	two = creatLinkedListWH();
	
	flush;
	out("从小到大排序?(Y/N)__\b\b");
	in("%c", &flag);

	sorted(one, toupper(flag));
	sorted(two, toupper(flag));
	head = sortedMerge(one, two, toupper(flag));

	traversalWH(head);

	pause;
}

NODE *sortedMerge(NODE *one, NODE *two, char flag)
{
	NODE *op, *tp, *head, *node, *p;
	node = newNode();
	head = node;
	op = one;
	tp = two;

	if (flag == 'Y') {
		while (op->next && tp->next) {
			if (op->next->data < tp->next->data) {
				p = op->next;
				op->next = p->next;
				p->next = NULL;
				node->next = p;
				node = p;
			}
			else {
				p = tp->next;
				tp->next = p->next;
				p->next = NULL;
				node->next = p;
				node = p;
			}
		}
		if (op->next == NULL) {
			p = tp->next;
			node->next = p;
		}else {
			p = op->next;
			node->next = p;
		}
	} else {
		while (op->next && tp->next) {
			if (op->next->data > tp->next->data) {
				p = op->next;
				op->next = p->next;
				p->next = NULL;
				node->next = p;
				node = p;
			}
			else {
				p = tp->next;
				tp->next = p->next;
				p->next = NULL;
				node->next = p;
				node = p;
			}
		}
		if (op->next == NULL) {
			p = tp->next;
			node->next = p;
		}
		else {
			p = op->next;
			node->next = p;
		}
	}
	return head;
}