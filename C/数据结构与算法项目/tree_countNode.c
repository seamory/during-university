#include "initHead.h"
#include "tree.h"

int countTreeInsideNode(treeNode *node);
int countTreeLeafNode(treeNode *node);

void tree_countNode(void)
{
	treeNode *root;
	root = creatTree();
	out("该树的非叶子结点为:%d, 叶子结点为:%d.", countTreeInsideNode(root), countTreeLeafNode(root));

	pause;
}

int countTreeInsideNode(treeNode *node)
{
	if (node) {
		if (node->lchild || node->rchild) {
			return countTreeInsideNode(node->lchild) + countTreeInsideNode(node->rchild) + 1;
		}else {
			return 0;
		}
	}
}

int countTreeLeafNode(treeNode *node)
{
	if (node) {
		if (node->lchild || node->rchild) {
			return countTreeLeafNode(node->lchild) + countTreeLeafNode(node->rchild);
		}
		else {
			return 1;
		}
	}
}