#include "initHead.h"
#include "tree.h"

void preorderTraversal(treeNode *node);
void inorderTraversal(treeNode *node);
void postorderTraversal(treeNode *node);

void tree_traversalSys(void)
{
	treeNode *root;
	root = creatTree();
	out("\n先序遍历序列:");
	preorderTraversal(root);
	out("\n中序遍历序列:");
	inorderTraversal(root);
	out("\n后序遍历序列:");
	postorderTraversal(root);
	pause;
}

void preorderTraversal(treeNode *node)
{
	if (node) {
		out("%d ", node->data);
		preorderTraversal(node->lchild);
		preorderTraversal(node->rchild);
	}
}

void inorderTraversal(treeNode *node)
{
	if (node) {
		inorderTraversal(node->lchild);
		out("%d ", node->data);
		inorderTraversal(node->rchild);
	}
};

void postorderTraversal(treeNode *node)
{
	if (node) {
		postorderTraversal(node->lchild);
		postorderTraversal(node->rchild);
		out("%d ", node->data);
	}
}
