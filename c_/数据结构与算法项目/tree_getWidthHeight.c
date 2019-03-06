#include "initHead.h"
#include "tree.h"

int getWidth(treeNode *root);
int getHeight(treeNode *node);

void tree_getWidthHeight(void)
{
	treeNode *root;
	root = creatTree();

	out("当前树的宽度为:%d,高度为:%d", getWidth(root), getHeight(root));
	pause;
}

int getWidth(treeNode *root)
{
	treeNode *node;
	int max = 1 , i = 1;
	queueNode *rear, *front;
	front = newQtreeNode();
	rear = front;
	node = root;

	if (node) {
		inTreeNode(&rear, node);
		while (!emptyTreeQueue(front)) {
			while (i) {
				outTreeNode(front, &rear, &node);
				if (node->lchild) {
					inTreeNode(&rear, node->lchild);
				}
				if (node->rchild) {
					inTreeNode(&rear, node->rchild);
				}
				i--;
			}
			i = countTreeQueue(front);
			max = max > i ? max : i;
		}
		return max;
	} else {
		return 0;
	}
}

int getHeight(treeNode *node)
{
	int lchild, rchild;
	lchild = 0;
	rchild = 0;
	if (!node) {
		return 0;
	} else {
		lchild = getHeight(node->lchild);
		rchild = getHeight(node->rchild);
		return  lchild > rchild ? lchild + 1 : rchild + 1;

	}
}