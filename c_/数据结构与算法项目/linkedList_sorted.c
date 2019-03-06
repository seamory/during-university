#include "initHead.h"
#include "linkedList.h"


void sorted(NODE *head, char flag);

void linkedList_sorted(void)
{
	NODE *head;
	char flag;
	head = creatLinkedListWH();
	flush;
	out("从小到大序列输出?(Y/N)__\b\b");
	in("%c", &flag);
	sorted(head, toupper(flag));
	traversalWH(head);
	pause;
}

void sorted(NODE *head, char flag)
{
	NODE *ep, *ip;
	int tmp;
	ep = head;
	while (ep->next != NULL) {
		ep = ep->next;
		ip = ep;
		while (ip->next != NULL) {
			ip = ip->next;
			if (flag == 'Y') {
				if (ep->data > ip->data) {
					tmp = ep->data;
					ep->data = ip->data;
					ip->data = tmp;
				}
			} else {
				if (ep->data < ip->data) {
					tmp = ep->data;
					ep->data = ip->data;
					ip->data = tmp;
				}
			}

		}
	}

}