#include "initHead.h"
#include "linkedList.h"

void linkedList_creatView()
{
	NODE *head;
	head = creatLinkedListWH();
	traversalWH(head);
	pause;
}