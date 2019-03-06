#include "initHead.h"
#include "linkedlist.h"

/*
创建一个结点
*/
NODE *newNode(void)
{
	NODE *node;
	node = (NODE *)malloc(sizeof(NODE));
	node->next = NULL;
	return node;
}

/*
创建带头结点链表
*/
NODE *creatLinkedListWH(void)
{
	NODE *head, *node;
	int x;
	node = newNode();
	head = node;

	puts("请输入每个元素的值，键入“0”完成创建。");
	in("%d", &x);
	while (x) {
		node->next = newNode();
		node = node->next;
		node->data = x;
		in("%d", &x);
	}
	return head;
}

/*
	通过数组创建一个带头结点的链表
*/
NODE *creatLinkedListBAWH(int *num, int length)
{
	NODE *head, *node;
	int i = 0;
	node = newNode();
	head = node;

	while (i<length) {
		node->next = newNode();
		node = node->next;
		node->data = *(num+i);
		i++;
	}
	return head;
}


/*
创建不带头结点链表
*/
NODE *creatLinkedListWNH(void)
{
	NODE *head, *node;
	int x;
	node = newNode();
	head = node;

	puts("请输入每个元素的值，键入“0”完成创建。");
	in("%d", &x);
	node->data = x;	//初始化头指针指向的元素

	while (x) {
		node->next = newNode();
		node = node->next;
		in("%d", &x);
		node->data = x;
	}
	return head;
}

/*
遍历带头结点链表
*/
void traversalWH(NODE *head)
{
	NODE *p;
	p = head;
	while (p->next) {
		p = p->next;
		out("%d ", p->data);
	}
}

/*
遍历不带头结点链表
*/
void traversalWNH(NODE *head)
{
	NODE *p;
	p = head;
	while (p) {
		p = p->next;
		out("%d ", p->data);
	}
}

/*
统计带头结点链表长度
*/
int linkedListLengthWH(NODE *head)
{
	NODE *p;
	int i = 0;
	p = head;
	while (p->next) {
		p = p->next;
		i++;
	}
	return i;
}

/*
统计不带头结点链表长度
*/
int linkedListLengthWNH(NODE *head)
{
	NODE *p;
	int i = 0;
	p = head;
	while (p) {
		p = p->next;
		i++;
	}
	return i;
}
