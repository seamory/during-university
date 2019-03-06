#pragma once
#ifndef LINKEDLIST
#define LINKEDLIST

typedef struct node {
	int data;
	struct node * next;
}NODE;

NODE *newNode(void);
NODE *creatLinkedListWH(void);
NODE *creatLinkedListWNH(void);
void traversalWH(NODE *head);
void traversalWNH(NODE *head);
int linkedListLengthWH(NODE *head);
int linkedListLengthWNH(NODE *head);

#endif
