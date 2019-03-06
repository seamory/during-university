#include <stdio.h>

typedef struct  node{
	int x;
	struct node *next;
} NODE;

int main()
{
	NODE *p, **P;
	p = (NODE *)malloc(sizeof(NODE));
	printf("p : %p\n", p);
	p -> x = 1;
	P = &p;
	printf("P : %p\n", P);
	printf("P : %p\n", *P);
	printf("p->x : %d\n", (*P) -> x);
}

//int *p // 创建一个指向int类型的指针	面向对象 int类型的地址 
//int **p	// 创建一个指向int指针的指针 面向对面 int类型指针的地址
