#include "initHead.h"
#include "tree.h"

void levelTravesal(treeNode *root);

void tree_levelTravsersal(void) 
{
	treeNode *root;
	root = creatTree();
	levelTravesal(root);

	pause;
}

void levelTravesal(treeNode *root) 
{
	treeNode *node;
	queueNode *rear, *front;
	front = newQtreeNode();
	rear = front;
	if (root) {
		inTreeNode(&rear, root);
		while (outTreeNode(front, &rear, &node)) {
			if (node) {
				out("%d ", node->data);
				inTreeNode(&rear, node->lchild);
				inTreeNode(&rear, node->rchild);
			}
		}
	} else {
		out("树为空树");
	}
}