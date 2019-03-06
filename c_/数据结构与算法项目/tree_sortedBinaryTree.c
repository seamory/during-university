#include "initHead.h"
#include "tree.h"

treeNode *creatSortedBinaryTree(int *num, int length);

void tree_sortedBinaryTree(void)
{
	int length, i, *num;
	out("请输入待排序列的长度:___\b\b\b");
	in("%d", &length);
	num = (int *)malloc(sizeof(int) * length);
	for (i = 0; i < length; i++) {
		in("%d", num + i);
	}
	treeNode *root;
	//int num[10] = {21,32,45,67,12,23,56,81,92,32};
	root = creatSortedBinaryTree(num, length);
	out("结果为:");
	inorderTraversal(root);
	pause;
}

treeNode *creatSortedBinaryTree(int *num, int length)
{
	treeNode *root, *p, *tmp;
	int i = 0, flag;
	root = newTreeNode();

	while (i < length) {
		flag = 1;
		p = root;
		if (i == 0) {
			p->data = num[i];
		}
		else {
			while (flag) {
				if (num[i] < p->data && p->lchild == NULL) {
					tmp = newTreeNode();
					tmp->data = num[i];
					p->lchild = tmp;
					flag = 0;
				}
				else if (num[i] >= p->data && p->rchild == NULL) {
					tmp = newTreeNode();
					tmp->data = num[i];
					p->rchild = tmp;
					flag = 0;
				}
				else if (num[i] < p->data && p->lchild != NULL) {
					p = p->lchild;
				}
				else if (num[i] >= p->data && p->rchild != NULL) {
					p = p->rchild;
				}
				else {
					puts("exist other condition.");
					flag = 0;
				}
			}
		}
		i++;
	}
	return root;
};
