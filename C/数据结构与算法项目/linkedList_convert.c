#include "initHead.h"
#include "linkedList.h"

void linkedList_convert(void)
{
	NODE *head, *tmp, *node;
	head = creatLinkedListWH();
	tmp = newNode();

	while (head->next) {
		node = head->next;
		head->next = node->next;
		node->next = tmp->next;
		tmp->next = node;
	}
	head = tmp;

	puts("链表倒置结果为:");
	traversalWH(head);
	pause;
}