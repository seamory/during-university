#include "initHead.h"
#include "tree.h"

void preorderTraversalUser(treeNode *node);
void inorderTraversalUser(treeNode *node);
void postorderTraversalUser(treeNode *node);

void tree_traversalUser(void)
{
	treeNode *root;
	root = creatTree();
	out("\n先序遍历序列(用户):");
	preorderTraversalUser(root);
	out("\n中序遍历序列(用户):");
	inorderTraversalUser(root);
	pause;
}

void preorderTraversalUser(treeNode *node)
{
	treeNode *p;
	stackNode *top;
	top = newStreeNode();
	p = node;
	while (p || !emptyTreeStack(top)) {
		if (p) {
			out("%d ", p->data);
		}
		if (p) {
			pushTreeNode(top, p);
			p = p->lchild;
		}
		else {
			popTreeNode(top, &p);
			if (p) {
				p = p->rchild;
			}
		}
	}
}

void inorderTraversalUser(treeNode *node)
{
	treeNode *p;
	stackNode *top;
	top = newStreeNode();
	p = node;
	while (p || !emptyTreeStack(top)) {
		if (p) {
			pushTreeNode(top, p);
			p = p->lchild;
		}
		else {
			if (p) {
				out("%d ", p->data);
			}
			popTreeNode(top, &p);
			if (p) {
				out("%d ", p->data);
				p = p->rchild;
			}
		}
	}
}

void postorderTraversalUser(treeNode *node)
{
	treeNode *p, *lp = NULL;
	stackNode *top, *top1;
	int flag = 0;
	top = newStreeNode();
	top1 = newStreeNode();
	p = node;
	while (p || !emptyTreeStack(top)) {
		if (p) {
			pushTreeNode(top, p);
			pushTreeNode(top1, p);
			p = p->lchild;
			flag = 0;
		}
		else {
			if (p) {
				out("%d ", p->data);
			}
			if (flag) {
				popTreeNode(top1, &lp);
				out("%d ", lp->data);
			}
			popTreeNode(top, &p);
			if (p) {
				p = p->rchild;
				flag = 1;
			}
		}
	}
}