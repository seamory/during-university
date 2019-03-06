#ifndef LINKEDLIST_H
#define LINKEDLIST_H

#include <stdio.h>
#include <stdlib.h>

#define rst fflush(stdin)
#define pause fflush(stdin); getch()
#define out(...) printf(__VA_ARGS__)
#define in(...) while(scanf(__VA_ARGS__)!=1){ rst; puts("ERROR INPUT!");}

typedef struct node{
	int data;
	struct node *next;
} NODE;

NODE *creatNode()
{
	NODE *node;
	node = (NODE *)malloc(sizeof(NODE));
	node -> next = NULL;
	return node;
}

void add(NODE *HEAD, int x)
{
	NODE *p, *node;
	p = HEAD;
	while(p -> next){
		p = p -> next;
	}
	node = creatNode();
	node -> data = x;
	node -> next = p -> next;	//使用creatNode函数已经初始化结点的下一个指针为NULL，此处可以省略
	p -> next = node;
}

void deleteByIndex(NODE *HEAD, int index)
{
	NODE *p, *q;
	p = HEAD;
	q = HEAD -> next;
	int i = 0;
	while(q){
		i++;
		if(i == index){
			p -> next = q -> next;
			free(q);
			break;
		}else{
			p = p -> next;
			q = q -> next;
		}
	}
}

void deleteBySearch(NODE *HEAD, int x)
{
	NODE *p, *q;
	int i = 0;
	p = HEAD;
	q = HEAD -> next;
	while(q){
		i++;
		if(q -> data == x){
			p -> next = q -> next;
			free(q);
			break;
		}else{
			p = p -> next;
			q = q -> next;
		}
	}
}

void update(NODE *HEAD, int x, int y)
{
	NODE *p;
	p = HEAD;
	while(p -> next){
		p = p -> next;
		if(p -> data == x){
			p -> data = y;
		}
	}
}

NODE *queryByIndex(NODE *HEAD, int index)
{
	NODE *p;
	int i = 0;
	p = HEAD;
	while(p -> next){
		i++;
		p = p -> next;
		if(index == i){
			return p;
		}
	}
	
	if(!p -> next){
		return NULL;
	}
}

NODE *queryBySearch(NODE *HEAD, int x)
{
	NODE *p;
	p = HEAD;
	while(p -> next){
		p = p -> next;
		if(p -> data == x){
			return p;
		}
	}
	
	if(!p -> next){
		return NULL;
	}
}

#endif

int main()
{
	NODE *head, *p;
	int i = 0;
	head = creatNode();
	p = head;
	for(i; i < 10; i++)
		add(head, i);
	update(head, 2, 10);
	while(p -> next){
		p = p -> next;
		printf("%d ", p -> data);
	}
}