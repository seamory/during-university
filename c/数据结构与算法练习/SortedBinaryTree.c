#include <stdio.h>
#include <stdlib.h>

#define rst fflush(stdin)
#define pause fflush(stdin); getch()
#define out(...) printf(__VA_ARGS__)
#define in(...) while(scanf(__VA_ARGS__)!=1){ rst; puts("ERROR INPUT!");}

typedef struct node{
	struct node *lchild;
	int data;
	struct node *rchild;
} NODE;

NODE *creatNode(void)
{
	NODE * node;
	node = (NODE *)malloc(sizeof(NODE));
	node -> lchild = NULL;
	node -> rchild = NULL;
	return node;
};

void inorderTraversal(NODE *node)
{
	if(node){
		inorderTraversal(node -> lchild);
		out("%d ", node -> data);
		inorderTraversal(node -> rchild);
	}
};

NODE *creatSortedBinaryTree(int *num, int length)
{
	NODE *root, *p, *tmp;
	int i = 0, flag;
	root = creatNode();
	
	while(i < length){
		flag = 1;
		p = root;
		if(i == 0){
			p -> data = num[i];
		}else{
			while(flag){
				if(num[i] < p -> data && p -> lchild == NULL){
					tmp = creatNode();
					tmp -> data = num[i];
					p -> lchild = tmp;
					flag = 0;
				}else if(num[i] >= p -> data && p ->rchild ==NULL){
					tmp = creatNode();
					tmp -> data = num[i];
					p -> rchild = tmp;
					flag = 0;
				}else if(num[i] < p -> data && p ->lchild !=NULL){
					p = p -> lchild;
				}else if(num[i] >= p -> data && p ->rchild !=NULL){
					p = p -> rchild;
				}else{
					puts("exist other condition.");
					flag = 0;
				}
			}
		}
		i++;
	}
	return root;
};

int main()
{
	int length, i, *num;
	out("Please input the length that the array you want to sort:___\b\b\b");
	in("%d", &length);
	num = (int *)malloc(sizeof(int) * length);
	for(i = 0; i < length; i++){
		in("%d", num + i);
	}
	NODE *root;
	//int num[10] = {21,32,45,67,12,23,56,81,92,32};
	root = creatSortedBinaryTree(num, length);
	inorderTraversal(root);
	return 0;
}
	
	